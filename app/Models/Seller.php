<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function productData(){
        return $this->hasMany(Product::class,'my_seller_id');
    }
   
}
