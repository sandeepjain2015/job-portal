<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function list(){
        return Seller::find(1)->productData;
        
    }
    public function manyProducts(){
        return Product::with('seller')->get();
    }
}
