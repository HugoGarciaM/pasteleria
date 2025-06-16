<?php

namespace App\Http\Controllers\Personal;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function sale(){
        return view('personal.sale');
    }

    public function settings(){
        $this->authorize('Role',Role::ADMIN);
        return view('personal.admin.Settings');
    }

    public function saleComplete(){
        return view('personal.saleComplete');
    }

    public function saleInProcess(){
        $deliveries = User::where('role',4)->get();
        return view('personal.saleProcess',compact(['deliveries']));
    }

    public function saleFailed(){
        return view('personal.saleFailed');
    }
    public function report(){
        return redirect(route(''));
        // return view('personal.admin.report');
    }
}
