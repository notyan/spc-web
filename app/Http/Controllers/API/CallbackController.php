<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CallbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apiKey = env("DUITKU_API_KEY");
        $merchantCode = $request->get('merchantCode');
        $amount = $request->get('amount');
        $merchantOrderId = $request->get('merchantOrderId');
        $productDetail = $request->get('productDetail');
        $additionalParam = $request->get('additionalParam');
        $paymentMethod = $request->get('paymentCode');
        $resultCode = $request->get('resultCode');
        $merchantUserId = $request->get('merchantUserId');
        $reference = $request->get('reference');
        $signature = $request->get('signature');
        
        //log callback untuk debug 
        // file_put_contents('callback.txt', "* Callback *\r\n", FILE_APPEND | LOCK_EX);
        
        if(!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)){
            $params = $merchantCode . $amount . $merchantOrderId . $apiKey;
            $calcSignature = md5($params);
        
            if($signature == $calcSignature){
                echo "TERVALIDASI";
                //Callback tervalidasi
                //Silahkan rubah status transaksi anda disini
                // file_put_contents('callback.txt', "* Success *\r\n\r\n", FILE_APPEND | LOCK_EX);
        
            }
            else{
                // file_put_contents('callback.txt', "* Bad Signature *\r\n\r\n", FILE_APPEND | LOCK_EX);
                throw new Exception('Bad Signature');
            }
        }
        else
        {
            // file_put_contents('callback.txt', "* Bad Parameter *\r\n\r\n", FILE_APPEND | LOCK_EX);
            throw new Exception('Bad Parameter');
        }
        
    }
}
