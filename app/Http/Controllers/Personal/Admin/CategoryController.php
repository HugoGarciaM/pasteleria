<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            $this->authorize('Role',Role::ADMIN);
            return $next($request);
        });
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|unique:categories'
        ]);
        $category=new Category();
        $category->name=$request->name;
        if($category->save()) return redirect(route('admin.product'));
        else return "no se pudo crear categoria";
    }

    public function delete($category){
        Category::destroy($category);
        return redirect(route('admin.product'));
    }

    public function update(Request $request,Category $category){
        //return $category;
        $category->name=$request->name;
        $category->save();
        return redirect(route('admin.product'));
    }
}
