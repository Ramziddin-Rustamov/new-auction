<?php

namespace App\Http\Controllers;

use App\Models\BiddingHistory;
use App\Models\CurrentBid;
use App\Models\Product;

class HomeController extends Controller
{


   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $myproducts = Product::where('user_id',auth()->user()->id)->get();
        $myproductBid = BiddingHistory::where('user_id',auth()->user()->id)->with(["product","user"])->get();
        return view("home",[
            "myproducts" => $myproducts,
            "myproductBid" => $myproductBid
        ]);
    }

  
}
