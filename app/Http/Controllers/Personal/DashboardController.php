<?php

namespace App\Http\Controllers\Personal;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware(function($request,$next){
            if(Auth::user()->role!=Role::CUSTOMERS)
                return $next($request);
            else
                return redirect(route('home'));
        });
    }

    public function __invoke(){
        return view('personal.dashboard');
    }

    public function index(){
        return view('personal.dashboard');
    }

    public function batch(){
        $this->authorize('Role',Role::ADMIN);
        return view('personal.admin.batchproduct');
    }

    public function product(){
        $this->authorize('Role',Role::ADMIN);
        return view('personal.admin.product');
    }

    public function employee(){
        $this->authorize('Role',Role::ADMIN);
        return view('personal.admin.employee');
    }

    public function customer(){
        $this->authorize('Role',Role::ADMIN);
        return view('personal.admin.customer');
    }
}
