<?php

namespace App\Http\Controllers\Api\V1;

use App\License;
use App\Http\Controllers\Controller;

class LicenseManagerController extends Controller
{
    public function info()
    {
        // verify post data
        if (! $this->verifyRequest($_REQUEST)) {
            return 'not working';
        }

        // Verify license
        if (! $this->verifyLicense($_REQUEST['product'], $_REQUEST['license'])) {
            return $this->errorResponse('Invalid license or license expired.');
        }

        return $this->getProductInfo($_REQUEST);
    }

    public function get()
    {
        // verify post data
        if (! $this->verifyRequest($_REQUEST)) {
            return 'not working';
        }

        // Verify license
        if (! $this->verifyLicense($_REQUEST['product'], $_REQUEST['license'])) {
            return $this->errorResponse('Invalid license or license expired.');
        }
        
        echo 'get';
    }

    public function getProductInfo($params)
    {
        $meta = [];

        $id = $params['product'];
        $key = $params['license'];

        $title = '';
        $description = '';
        $version = isset($meta['version']) ? $meta['version'] : '';
        $tested = isset($meta['tested']) ? $meta['tested'] : '';
        $last_updated = isset($meta['updated']) ? $meta['updated'] : '';
        $author = isset($meta['author']) ? $meta['author'] : '';
        $banner_low = isset($meta['banner_low']) ? $meta['banner_low'] : '';
        $banner_high = isset($meta['banner_high']) ? $meta['banner_high'] : '';

        return [
            'name'              => $title,
            'description'       => $description,
            'version'           => $version,
            'tested'            => $tested,
            'author'            => $author,
            'last_updated'      => $last_updated,
            'banner_low'        => $banner_low,
            'banner_high'       => $banner_high,
            "package_url"       => url('/api/v1/license-manager/get?product=' . $id . '&license=' . urlencode($key))
        ];
    }

    private function verifyRequest($params)
    {
        if (! isset($_REQUEST) || ! isset($params['product']) || ! isset($params['license'])) {
            return false;
        }

        return true;
    }

    private function verifyLicense($product, $key)
    {
        $license = $this->findLicense($product, $key);

        if (! $license) {
            return false;
        }

        $valid_until = strtotime($license->valid_until);

        if ($license->valid_until != null && time() > $valid_until) {
            return false;
        }

        return true;
    }

    private function findLicense($product, $key)
    {
        $license = License::where([
            ['product_id', '=', $product],
            ['license_key', '=', $key]
        ])->first();

        if ($license) {
            return $license;
        }

        return false;
    }

    private function sendResponse($response)
    {
        echo json_encode($response);
    }

    private function errorResponse($msg)
    {
        return ['error' => $msg];
    }
}
