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
}
