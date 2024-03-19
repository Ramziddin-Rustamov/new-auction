<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CurrentBid;
use Illuminate\Http\Request;

class ComplitedProductsController extends Controller
{

    public function getAllInactiveProducts()
    {
        $compilitedProducts = CurrentBid::where("status", null)->get();

        return view("complited-products.complited-products",[
            "compilitedProducts" =>$compilitedProducts
        ]);
    }

}
