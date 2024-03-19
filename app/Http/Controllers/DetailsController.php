<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CurrentBid;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    // public function view($id){
    //     $currentBid  = CurrentBid::where("product_id",$id)->get();
    //     return view("details",[
    //         "currentBid" =>$currentBid
    //     ]);
    // }

    public function view($id){


        $product = Product::findOrFail($id);

        $currentBids = $product->currentBids;
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
        $find->each->delete();
    } else {
        $currentBid = new CurrentBid();
        $currentBid->user_id = 16; // Assuming 6 is the authenticated user's ID
        $currentBid->product_id = $request->product_id;
        $currentBid->price = $request->newPrice;
        $currentBid->save();
        return redirect()->back()->with('success', 'Bid margin added successfully.');
    }
  }

}
