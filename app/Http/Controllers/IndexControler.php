<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexControler extends Controller
{
    public function index(){
        $products = Product::all();
        return view("index",[
            "products" =>$products,
        ]);
    }

}
