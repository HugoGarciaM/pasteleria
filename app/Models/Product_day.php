<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Product_day extends Model
{
    use HasFactory;
    public $timestamps=null;

    public function date(){
        return $this->belongsTo(Date::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
