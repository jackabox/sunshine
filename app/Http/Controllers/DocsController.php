<?php

namespace App\Http\Controllers;

use Exception;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Storage;
use Illuminate\Http\Request;

use League\CommonMark\CommonMarkConverter;

class DocsController extends Controller
{

    public function page(Request $request)
    {
        $props = $this->getProperties($request);
        return view('docs/page')->with($props);
    }

    public function getProperties($request) : array
    {
        $path = $request->path();
        $path = str_replace('docs/', '', $path);

        try {
            $content = Storage::disk('content')->get($path . '.md');
        } catch (Exception $e) {
            abort(404);
        }

        // instantiate and call
        $document = YamlFrontMatter::parse($content);

        // properties
        $pageProperties = $document->matter();
        $pageProperties['pagePath'] = $request->path();
        $pageProperties['content'] = (new CommonMarkConverter())->convertToHtml($document->body());

        return $pageProperties;
    }
}
