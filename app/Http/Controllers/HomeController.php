<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // if($request['name']=='') $request['name']="null";
        // if($request['category']=='' || $request['category']==0) $request['category']="null";
        if($request->stat==null) $request['stat'] = 'available';
        return Auth::user()->role!=Role::CUSTOMERS ? redirect(route('admin')) : view('home',[
            'request' => $request
        ]);
    }
}
