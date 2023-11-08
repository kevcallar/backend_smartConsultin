<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\EmailCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailCodeController extends Controller
{
    //
    public function store(Request $request)
{
    $validatedData = Validator::make($request->all(),[
        'otp'=>'required|integer',
        'email'=>'email|required'
    ]);

    if($validatedData->fails()){
        return response()->json(['errors' => $validatedData->errors()], 500);
    }

    $code= new EmailCode;
    $code->otp=$request->input('otp');
    $client=Client::where('email',$request->input('email'));
    $clientId=$client->id;
    $code->client_id=$clientId;

    $code->save();

    return response()->json(['success'=>'se ha guardado el código'],200);
}
}
