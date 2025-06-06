<?php

namespace App\Models;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     public function seller(){
        return $this->belongsTo(Seller::class, 'my_seller_id');
    }
}
