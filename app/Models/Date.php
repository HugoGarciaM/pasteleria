<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;
    public $timestamps=false;

    public function products(){
        return $this->hasMany(Product_day::class);
    }
}
