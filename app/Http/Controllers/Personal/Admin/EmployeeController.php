<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){

    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|string'
        ]);
        $user=new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role
        ]);

        if($user->save()){
            return redirect(route('admin.employee'));
        }else{
            return "no se pudo crear usuario";
        }
    }
}
