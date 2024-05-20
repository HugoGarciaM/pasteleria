<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Models\Product_day;
use Illuminate\Http\Request;

class ProductDayController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return redirect(route('admin.batch'));
    }

    public function newBatch(Request $request){
        $request->validate([
            'date' => 'unique:dates,event_day'
        ]);
        $batch = new Date();
        if($batch->save())
            return redirect(route('admin.batch'));
        else
            return "este dia ya existe";
    }

    public function create(Request $request,$date){
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'idp' => 'exists:products,id'
        ]);
        $product=new Product_day();
        $product->product_id=$request->idp;
        $product->quantity=$request->quantity;
        $product->date_id=$date;
        if($product->save()){
            return redirect(route('admin.batch'));
        }else{
            return "no se pudo crear";
        }
    }

    public function delete($id){
        Product_day::destroy($id);
        return redirect(route('admin.batch'));
    }

    public function update(Request $request,Product_day $detail){
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $detail->quantity=$request->quantity;
        if($detail->save()){
            return redirect(route('admin.batch'));
        }else{
            return "no se pudo editar";
        }
    }
}
