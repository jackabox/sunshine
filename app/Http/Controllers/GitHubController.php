<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Github\Client as GitHub;

class GitHubController extends Controller
{
    public $client;
    private $user;

    public function __construct()
    {
        $this->client = new GitHub();
        $this->client->authenticate(env('GITHUB_TOKEN'), '', GitHub::AUTH_URL_TOKEN);

        $this->user = 'adtrak';
    }

    public function getRepositories()
    {
        $repositories = $this->client->api('organizations')->repositories($this->user);
        return $repositories;
    }

    public function ajaxReleases()
    {
        $response = $this->getReleases($this->user, $_POST['repo']);
        $releases = [];

        foreach ($response as $rep) {
            $releases[] = [
                'name'  => $rep['tag_name'],
                'id'    => $rep['id']
            ];
        }

        echo json_encode($releases);
        die();
    }

    public function getReleases($user, $repo)
    {
        $releases = $this->client->api('repo')->releases()->all($user, $repo);
        return $releases;
    }

    public function ajaxFetchFiles()
    {
        // $this->getDownloadFile();
        $repo = $_POST['repo'];
        $release = $_POST['release'];

        $release = $this->client->api('repo')->releases()->show($this->user, $repo, $release);
        $version = str_replace(' ', '-', $release['tag_name']);

        $this->getDownloadFile($_POST['repo'], $release['zipball_url']);
        $file_details = $this->organizeZip($_POST['repo'], $version);

        $data = [
            'version'   => $version
        ];

        $data = array_merge($data, $file_details);
        echo json_encode($data);
        die();
    }

    private function downloadFile($filename, $url) {
        $url = $url . '?access_token=' . env('GITHUB_TOKEN');
        $path = public_path() . "/tmp/dl/{$filename}.zip";

        // set headers so that github accepts file
        $opts = [
            'http' => [
                    'method' => 'GET',
                    'header' => [
                            'User-Agent: PHP'
                    ]
            ]
        ];

        $context = stream_context_create($opts);
        $content = file_get_contents($url, false, $context);
        file_put_contents($path, $content);

        return $path;
    }

    private function getDownloadFile($filename, $url) {
        if (! file_exists(public_path() . '/tmp/dl/' . $filename)) {
            $this->downloadFile($filename, $url, env('GITHUB_TOKEN'));
        }

        return public_path() . "/tmp/dl/{$filename}.zip";
    }

    /*
        downloads the zips, extracts it, names it properly, compiles and moves to a better location.
    */
    private function organizeZip($filename, $release)
    {
        $original = public_path() . "/tmp/dl/{$filename}.zip";
        $rootPath = public_path() . '/tmp/extract/' . $filename;
        $file_path = public_path() . "/downloads/{$filename}/";
        $file_name = "{$filename}-{$release}.zip";
        $destination = $file_path . $file_name;

        if (! is_dir(public_path() . "/downloads/{$filename}/")) {
            mkdir(public_path() . "/downloads/{$filename}/");
        }

        $zip = new \ZipArchive;
        $zip->open($original);
        $zip->extractTo(public_path() . '/tmp/extract');
        $zip->close();

        // grab the extracted folder
        $folder = array_filter(glob(public_path() . '/tmp/extract/*'), 'is_dir');

        // rename the folder (there should only be one so we use root[0])
        rename($folder[0], $rootPath);

        // zip the new file.
        $this->createZip($rootPath, $destination);

        // delete the old files
        $this->deleteTmpZip($original);
        $this->deleteFiles($rootPath);

        return [
            'file_name' => $file_name,
            'file_path' => $file_path
        ];
    }

    private function createZip($source, $destination)
    {
        $zip = new \ZipArchive();

        if (! $zip->open($destination, \ZipArchive::CREATE))
            return false;

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/')+1), array('.', '..')))
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                } elseif (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } elseif (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    private function deleteTmpZip($file)
    {
        unlink($file);
    }

    private function deleteFiles($dir)
    {
        foreach(scandir($dir) as $file) {
            // skip . and .. files
            if ('.' === $file || '..' === $file)
                continue;

            // add trailing slash
            $dir = rtrim( $dir, '/\\' ) . '/';

            // if is new direct, repeat else delete
            if ( is_dir( $dir . $file ) ) {
               $this->deleteFiles( $dir . $file );
            } else {
                unlink($dir . $file);
            }
        }

        // remove the directory
        rmdir($dir);
    }
}
