<?php

namespace App\Http\Controllers\Personal;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getPerson($ci=null){
        if(auth()->user()->role==Role::CUSTOMERS) return response(['message'=>'Unauthorized'],401);
        if($ci==null) return response()->json(['persons' => Person::all()],200);
        else{
            $person=Person::where('ci',$ci)->first();
            if($person!=null) return response()->json([
                'person' => $person,
            ],200);
            else return response()->json([
                'message' => 'Not Found',
            ],404);
        }
    }
}
