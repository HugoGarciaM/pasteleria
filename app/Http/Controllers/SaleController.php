<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Enums\Status;
use App\Enums\Type_transaction;
use App\Http\Controllers\Controller;
use App\Models\Date;
use App\Models\Person;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SaleController extends Controller
{
    public function register(Request $request){
        // return $request;
        $request->validate([
            'ci '=> 'nullable|integer',
            'name' => 'nullable|string',
            'data' => 'required|json|min:1',
            'type' => 'required|integer',
            'pay' => 'integer'
        ]);
        $productBatch=Date::first();
        foreach(json_decode($request->data,true) as $data){
            $max= $productBatch->verifyStock($data['id'])!=null ? $productBatch->verifyStock($data['id'])[0]->stock : 0;
            Validator::make($data,[
                'id' => 'required|integer|exists:products,id',
                'price' => 'required|integer',
                'quantity' => 'required|integer|min:1|max:'.$max,
            ])->validate();
        }
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
            $seller=null;
            if($request->user()->role == Role::ADMIN || $request->user()->role == Role::PERSONAL) $seller = $request->user()->id;
            $transaction->seller = $seller;
            $transaction->status = $seller!=null ? Status::DISABLE : Status::ENABLE;
            $transaction->type= $request->type==0 ? Type_transaction::OFFLINE : Type_transaction::ONLINE;
            if($request->type==1){
                $transaction->detail_pay_id=$request->pay;
            }
            $transaction->save();
            $transaction->details()->createMany($details);
            DB::commit();
            return redirect(route('personal.sale.pdf',$transaction->id));
        } catch (\Exception $e) {
            DB::rollBack();
            return "hubo un error: ";
        }
    }

    public function showPayment(Request $request,$transaction){
        return view('personal.payment',['transaction' => $transaction]);
    }

    public function Receipt(Request $request,Transaction $transaction){
        $qr=QrCode::generate($transaction->id);
        $seller = isset($transaction->_seller->person->name) ? explode(' ',trim($transaction->_seller->person->name)) : null;
        $quantity = sizeof($transaction->details);
        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true]
        )->loadView('pdf.receipt',[
            'id' => $transaction->id,
            'ci'=> isset($transaction->_customer->ci) ? $transaction->_customer->ci : null,
            'name' => isset($transaction->_customer->name) ? $transaction->_customer->name : null,
            'payment' => $transaction->type==Type_transaction::OFFLINE ? 'Efectivo' : 'QR',
            'seller' =>  $seller[0]." ".$seller[1][0].".",
            'timestamps' => $transaction->created_at,
            'details' => $transaction->details,
            'qr' => $qr
        ])->setPaper([
            0,
            0,
            226.77192,
            400+$quantity*30 //400 inc 30
        ]);

        $pdf->render();
        return $pdf->stream('hola.pdf');
    }

    public function saleComplete(Request $request){
        $request->validate([
            'date' => 'date_format:Y-m-d'
        ]);
    }

    public function getProduct(Request $request){
        $request->validate([
            'id' => 'exists:products,id'
        ]);
        $product = Date::first()->verifyStock($request->id);
        if($product!=null){
            return response()->json([
                'product'=>$product[0]
            ],200) ;
        }else{
            return response()->json([
                'message'=>'Not Found'
            ],404) ;
        }
    }

}
