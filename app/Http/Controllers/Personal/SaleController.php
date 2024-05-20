<?php

namespace App\Http\Controllers\Personal;

use App\Enums\Status;
use App\Enums\Type_transaction;
use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Models\Person;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function register(Request $request){
        // return Date::where('event_day',date('Y-m-d'))->first();
        // return Date::first()->stockProducts('2024-05-19');
        $request->validate([
            'ci '=> 'nullable|integer',
            'name' => 'nullable|string',
            'data' => 'required|json'
        ]);
        $data=json_decode($request->data);
        DB::beginTransaction();
        $details=[];
        foreach($data as $product){
            $details[] = [
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $product->quantity
            ];
        }
        try {
            $transaction=new Transaction();
            if($request->filled('ci')){
                $person=Person::where('ci',$request->ci)->first();
                if($person==null){
                    $person=new Person([
                        'ci' => $request->ci,
                        'name' => $request->name
                    ]);
                    $person->save();
                }
                $transaction->customer=$person->id;
            }
            $transaction->seller=$request->user()->id;
            $transaction->status=Status::DISABLE;
            $transaction->type=Type_transaction::OFFLINE;
            $transaction->save();
            $transaction->details()->createMany($details);
            DB::commit();
            return "correcto";
        } catch (\Exception $e) {
            DB::rollBack();
            return "hubo un error: ";
        }
    }
}
