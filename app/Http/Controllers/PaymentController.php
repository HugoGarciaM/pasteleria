<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function generateQR(Request $request){
        $client = new Client();
        $api = 'http://localhost:8001/api/qr/generate';
        try {
            $response = $client->post(
                $api,
                [
                    // 'user' =>
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
