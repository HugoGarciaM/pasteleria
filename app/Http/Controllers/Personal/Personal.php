<?php

namespace App\Http\Controllers\Personal;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Personal extends Controller
{
    public function __construct(){
        $this->middleware(function(){
            $this->authorize('Role',[Role::PERSONAL]);
        });
    }
}
