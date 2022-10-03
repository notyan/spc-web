<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $merchantCode = env('DUITKU_MERCHANT_ID'); 
        $apiKey = env("DUITKU_API_KEY");

        $datetime = date('Y-m-d H:i:s');  
        $paymentAmount = 10000;
        $signature = hash('sha256',$merchantCode . $paymentAmount . $datetime . $apiKey);

        $params = array(
            'merchantcode' => $merchantCode,
            'amount' => $paymentAmount,
            'datetime' => $datetime,
            'signature' => $signature
        );


        $url =  env("DUITKU_URL").'/webapi/api/merchant/paymentmethod/getpaymentmethod'; 
        $response = Http::post($url, $params);
        echo $response->status();
        echo $response->body();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $merchantCode = env('DUITKU_MERCHANT_ID'); 
        $apiKey = env("DUITKU_API_KEY");
        $paymentMethod = 'SP'; 
        $paymentAmount =  $request->get('total');
        $merchantOrderId = time() . ''; // dari merchant, unik
        $productDetails = 'Tes pembayaran menggunakan Duitku';
        $callbackUrl = env("APP_URL").':8000/api/callback'; // url untuk callback
        $returnUrl = env("APP_URL"); // url untuk redirect
        $expiryPeriod = 10; // atur waktu kadaluarsa dalam hitungan menit
        $signature = md5($merchantCode . $merchantOrderId . $paymentAmount . $apiKey);
        $url =  env("DUITKU_URL").'/webapi/api/merchant/v2/inquiry'; // Sandbox

        $params = array(
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount ,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'customerVaName' => $request->get('nama'),
            'email' => $request->get('email'),
            // 'accountLink' => $accountLink,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => $expiryPeriod
        );

        
        print_r($params);
        $response = Http::post($url, $params);
        echo "\n";
        echo $response->status();
        echo "\n";
        echo $response->body();

    }
}
