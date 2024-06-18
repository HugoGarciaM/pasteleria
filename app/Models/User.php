<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person_ci',
        'email',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'status' => Status::class
        ];
    }

    public function person(){
        return $this->hasOne(Person::class,'ci','person_ci');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class,'seller','id');
    }

    // public function name():Attribute{
    //     return new Attribute(
    //         get: fn($value) => ucwords(strtolower($value)),
    //         set: fn($value) => strtoupper($value)
    //     );
    // }
    //
    // public function surname():Attribute{
    //     return new Attribute(
    //         get: fn($value) => ucwords(strtolower($value)),
    //         set: fn($value) => strtoupper($value)
    //     );
    // }
}
