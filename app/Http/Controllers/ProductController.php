<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  

    public function index()
    {
        return view("product.index");
    }

    public function store(Request $request)
    {
        return view("product.create");
    }

    public function show()
    {
        return view("product.view");
    }

}
