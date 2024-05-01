<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PasswordMail;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Nette\Utils\Random;

class EmployeeController extends Controller
{
    public function index(){

    }

    public function create(Request $request){
        $request->validate([
            'ci' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|unique:users|email'
        ]);
        $p=Person::where('ci',$request->ci)->first();
        if(!$p){
            $p=new Person();
            $p->ci=$request->ci;
        }
        $p->name=$request->name;
        $p->save();
        $user=new User([
            'person_ci'=>$request->ci,
            'email' => $request->email,
            'password' => Random::generate(),
            'role' => $request->role
        ]);

        if($user->save()){
            $token=Password::createToken($user);
            Mail::to($user->email)->send(new PasswordMail('Pasteleria Pepita',$user,route('password.reset',$token).'?email='.$user->email));
            return redirect(route('admin.employee'));
        }else{
            return "no se pudo crear usuario";
        }
    }

    public function update(Request $request,User $user){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'min:8|string'
        ]);
        $user->person->update(['name'=> $request->name]);
        $user->email=$request->email;
        $user->role=$request->role;
        if($request->password)
            $user->password=$request->password;
        $user->save();
        return redirect(route('admin.employee'));
    }

    public function delete($id){
        User::destroy($id);
        return redirect(route('admin.employee'));
    }
}
