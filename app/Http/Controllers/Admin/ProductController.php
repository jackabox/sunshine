<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Release;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GitHubController;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('admin.products.index')
                    ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $repos = new GitHubController();
        $repos = $repos->getRepositories();

        return view('admin.products.create')
                    ->with('repos', $repos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'description'   => 'required'
        ]);

        // $request->description;
        $product = new Product();
        $product->name = $request->title;
        $product->description = $request->description;
        $product->public = $request->public;
        $product->save();

        if (isset($request->file_name) && $request->file_name != '') {
            $url = (explode("public/", $request->file_path));
            $url = url('/' . $url[1]);

            $release = new Release();
            $release->product_id = $product->id;
            $release->version = $request->file_version;
            $release->src = 'GitHub';
            $release->file_url = $url;
            $release->file_name = $request->file_name;
            $release->save();
        }

        return redirect()->route('admin.products.edit', $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', '=', $id)->first();

        $github = new GitHubController();
        $repos = $github->getRepositories();
        $latest = $product->releases()->orderby('created_at', 'desc')->first();

        if ($latest) {
            $releases = $github->getReleases('adtrak', $latest->repo_name);
        } else {
            $releases = null;
            $latest = (object) [
                'repo_name' => '',
                'folder_name' => ''
            ];
        }

        return view('admin.products.edit')
                ->with('repos', $repos)
                ->with('product', $product)
                ->with('releases', $releases)
                ->with('latest_release', $latest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo 'updating ' . $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo 'destroy ' . $id;
    }
}
