<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\Type_transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function customers(){
        return $this->belongsTo(User::class,'customer','id');
    }

    public function sellers(){
        return $this->belongsTo(User::class,'seller','id');
    }

    public function details(){
        return $this->hasMany(Detail_product::class);
    }

    protected function casts(): array
    {
        return [
            'status'=>Status::class,
            'type'=> Type_transaction::class
        ];
    }
}
