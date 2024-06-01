<?php

namespace App\Http\Controllers\Personal\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function testConectionBank(Request $request){
        $url="http://localhost:8001/api/balance";
        $body=[
            'user' => $request->user,
            'password' => $request->password,
            'account' => $request->account
        ];
        $client = new Client();
        $client->post($url,$body);
    }
}
