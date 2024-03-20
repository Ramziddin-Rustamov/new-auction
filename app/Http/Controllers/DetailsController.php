<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CurrentBid;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailsController extends Controller
{


    public function view($id){


        $product = Product::findOrFail($id);

        $currentBids = $product->currentBids->sortByDesc('price');
        return view("details",[
            "currentBids" =>$currentBids,
            "product" =>$product,
        ]);
    }

    public function addBidmargin(Request $request)
     {
    $find = CurrentBid::where("product_id", $request->product_id)->get();

    if ($find->isNotEmpty()) {
        foreach ($find as $bid) {
            if ($bid->price >= $request->newPrice) {
                return redirect()->back()->with('error', 'Price is equal or less than the last offer price!');
            }
        }
    }
    $currentBid = new CurrentBid();
    $currentBid->user_id =  1;//Auth::user()->id;
    $currentBid->product_id = $request->product_id;
    $currentBid->price = $request->newPrice;
    $currentBid->save();
    return redirect()->back()->with('success', 'Offer added!');
  }

}
