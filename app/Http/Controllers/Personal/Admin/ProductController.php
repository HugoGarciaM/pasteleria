<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Enums\Role;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'description'=>$request->description,
            'category_id'=>$request->category,
            'status'=>$request->status!=null ? Status::ENABLE : Status::DISABLE
        ]);

        if($product->save()){
            if($request->file('picture')!=null) Storage::disk('imgProduct')->putFileAs($request->file('picture'),$product->id);
            return redirect(route('admin.product'));
        }else{
            return "no se pudo crear";
        }
    }

    public function update(Request $request,Product $product){
        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'category'=>'nullable|exists:categories,id',
            'status'=>Rule::enum(Status::class)
        ]);
        $product->name=$request->name;
        $product->price=$request->price;
        $product->description=$request->description;
        $product->category_id=$request->category;
        $product->status=$request->status!=null ? Status::ENABLE : Status::DISABLE;
        if($product->save()){
            if($request->file('picture')!=null){
                if(Storage::disk('imgProduct')->exists($product->id))
                    Storage::disk('imgProduct')->delete($product->id);
                Storage::disk('imgProduct')->putFileAs($request->file('picture'),$product->id);
            }
            return redirect(route('admin.product'));
        }else{
            return "no se pudo crear";
        }
    }

    public function delete(Product $product){
        Product::destroy($product);
    }

    public function showImg($id){
        return Storage::disk('imgProduct')->exists($id) ? Storage::disk('imgProduct')->get($id) : Storage::disk('imgProduct')->get('Image_not_available.png');
    }
}
