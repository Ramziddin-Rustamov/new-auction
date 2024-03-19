<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InactiveProductsController extends Controller
{
   public function getAllInactiveProducts(){
    return view("inactive-products");
   }
}
