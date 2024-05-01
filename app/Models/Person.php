<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table='persons';

    protected $fillable=[
        'ci',
        'name'
    ];


    public function name():Attribute{
        return new Attribute(
            get: fn($value) => ucwords(strtolower($value)),
            set: fn($value) => strtoupper($value)
        );
    }

    public function user(){
        return $this->hasMany(User::class,'person_ci','ci');
    }
}
