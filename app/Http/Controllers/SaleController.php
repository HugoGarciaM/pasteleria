<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\Type_transaction;
use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SaleController extends Controller
{
    public function registerOffline(Request $request){
        $request->validate([
            'ci '=> 'nullable|integer',
            'name' => 'nullable|string',
            'data' => 'required|json|min:1'
        ]);
        foreach(json_decode($request->data,true) as $data){
            $v=Validator::make($data,[
                'id' => 'required|integer|exists:products,id',
                'price' => 'required|integer',
                'quantity' => 'required|integer'
            ])->validate();
        }
        // return view('personal.payment',['transaction' => '']);
        // return view('personal.payment');
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
            return redirect(route('personal.sale.pdf',$transaction->id));
            // return view('personal.payment',['transaction' => $transaction->id]);
            // return view('pdf.receipt',$transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            return "hubo un error: ";
        }
    }

    public function showPayment(Request $request,$transaction){
        return view('personal.payment',['transaction' => $transaction]);
    }

    public function Receipt(Request $request,Transaction $transaction){
        // $transaction=Transaction::find(5);
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
}
