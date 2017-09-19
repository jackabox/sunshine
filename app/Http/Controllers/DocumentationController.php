<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DocumentationController extends Controller
{

    public function index()
    {
        return view('docs.index');
    }

    public function docs($id)
    {
        return view('docs');
    }
}
