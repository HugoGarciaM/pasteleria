<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Business_info;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(){
        $this->middleware(function($request,$next){
            $this->authorize('Role',Role::ADMIN);
            return $next($request);
        });
    }

    public function testConectionBank(Request $request){
        // $url="http://localhost:8001/api/balance";
        $url = env('BANK_API')."/api/balance";
        $options =[
            'headers' => [
                'Authorization' => 'Bearer '.$request->token,
                'Accept' => 'application/json'
            ],
        ];
        try {
            $client = new Client();
            $response = $client->request('POST',$url,$options);
            if($response->getStatusCode()=='200'){
                $json = json_decode($response->getBody());
                return response()->json($json,200);
            }else{
                return response()->json(['message'=>'error'],404);
            }
        } catch (RequestException $e) {
            return response()->json(['message' => 'Error'],404);
        }
    }

    public function saveBank(Request $request){
        $bank = Business_info::updateOrCreate(
            ['id' => 1],
            [
                'bank' =>$request->bank,
                'number_account' =>$request->account,
                'token' =>$request->token,
            ]
        );
        return redirect(route('admin.settings'));
    }
}
