<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_day extends Model
{
    use HasFactory;

    public function date(){
        return $this->belongsTo(Date::class);
    }

    public function product(){
        return $this->belongsTo(product::class);
    }

}
