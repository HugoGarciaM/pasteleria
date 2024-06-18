<?php

namespace App\Http\Controllers;

use App\Models\Business_info;
use App\Models\Detail_pay;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function generateQR(Request $request){
        $validator = Validator::make($request->all(),[
            'quantity' => 'required|integer'
        ]);

        if($validator->fails()) return response(['message' => 'Error'],400);
        $info=Business_info::first();
        $client = new Client();
        $api = env('BANK_API').'/api/qr/generate';
        $options =[
            'headers' => [
                'Authorization' => 'Bearer '.$info->token,
                'Accept' => 'application/json'
            ],
            'json' =>[
                'account' => $info->number_account,
                'quantity' => $request->quantity
            ]
        ];
        try {
            $response = $client->request('POST',$api,$options);
            $qr=QrCode::generate($response->getBody());
            $id = (json_decode($response->getBody()))->id;
            $qrBase64 = base64_encode($qr);
            if($response->getStatusCode()==200){
                $registerQr = new Detail_pay([
                    'qr' => $qr,
                    'status' => 1
                ]);
                $registerQr->save();
                return response()->json(['qrcode'=>$qrBase64,'id'=>$id,'idq'=>$registerQr->id],200);
            }else{
                return response()->json(['message'=>'error es '.$response->getStatusCode()],404);
            }
        } catch (\Throwable $th) {
                return response()->json(['message'=>'error '.$th],404);
        }
    }

    public function verifyQR(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer'
        ]);

        if($validator->fails()) return response(['message' => 'Error: no se envio quantity'],400);
        $info=Business_info::first();
        $client = new Client();
        $url=env('BANK_API').'/api/qr/status';
        $options =[
            'headers' => [
                'Authorization' => 'Bearer '.$info->token,
                'Accept' => 'application/json'
            ],
            'json' =>[
                'id' => $request->id
            ]
        ];
        try {
            $response = $client->request('POST',$url,$options);
            $json= json_decode($response->getBody());
            if($response->getStatusCode()==200 && $json->message=='qr disabled'){
                $registerQr = Detail_pay::find($request->idq);
                $registerQr->status=0;
                $registerQr->save();
                return response()->json(['status'=>true],200);
            }else{
                return response()->json(['status'=>false],404);
            }
        } catch (\Throwable $th) {
                return response()->json(['message'=>'error '.$th],404);
        }
    }
}
