<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Enums\Role;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware(function($request,$next){
            $this->authorize('Role',Role::ADMIN);
            return $next($request);
        });
    }

    public function show(){
        $product=Product::all();
        return $product;
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'category'=>'nullable|exists:categories,id',
            'status'=>Rule::enum(Status::class)
        ]);

        $product=new Product([
            'name'=>$request->name,
            'price'=>$request->price,
            'category_id'=>$request->category,
            'status'=>$request->status!=null ? Status::ENABLE : Status::DISABLE
        ]);

        if($product->save()){
            return redirect(route('admin.product'));
        }else{
            return "no se pudo crear";
        }
    }

    public function delete(Product $product){
        Product::destroy($product);
    }
}
