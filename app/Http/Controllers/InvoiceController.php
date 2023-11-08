<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Barryvdh\DomPDF\PDF;
use App\Mail\invoiceMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function store(Request $request) //guarda el ticket y manda un mail con los datos
    {
        // Validate the request data
        $validatedData = Validator::make($request->all(),[
            'id' => 'required|numeric', //falta el unique
            'fecha' => 'required|date',
            'nombre' => 'required|string',
            'cifCliente' => 'required|string', //falta el unique
            'desc' => 'required|string',
            'precioUnitario' => 'required|numeric|min:0',
            'precioTotal' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'precioFinal' => 'required|numeric|min:0',
            'email'=>'required'
        ]);
        
        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 500);
        }
    
    
        // Create a new invoice object
        $invoice = new Invoice();
        // $client=Client::where('cifCliente',$invoice->cifCliente);
        // $client=Client::find($invoice->client->id);
        // dd($client);
        
        $invoice->id = $request->input('id');
        $invoice->nombre = $request->input('nombre');
        $invoice->fecha = $request->input('fecha');
        $invoice->cifCliente = $request->input('cifCliente');//cif cliente desde el id
        $invoice->desc = $request->input('desc');
        $invoice->precioUnitario = $request->input('precioUnitario');
        $invoice->preciototal = $request->input('precioTotal');
        $invoice->iva = $request->input('iva');
        $invoice->precioFinal = $request->input('precioFinal');
        $client=Client::where('email',$request->input('email'))->first();
        $invoice->client_id = $client->id;
        $invoice->save();

        //guarda el ticket
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', ['invoice' => $invoice]);
        $pdf->save(storage_path('app/public/invoices/'.$invoice->id.'.pdf'));
    
        // Send the email
        $status=Mail::to($request->input('email'))->send(new invoiceMail($invoice));
        if(!$status){
            return response()->json(['error'],404);
        }
    
        return response()->json(['message' => 'Invoice stored successfully'], 200);
    }

    public function index()  //genera un id random
    {
        $id = mt_rand(1, 9999); // generate a random 8-digit ID
        $idExists = Invoice::where('id', $id)->exists(); // check if the ID already exists in the database
        while ($idExists) {
            $id = mt_rand(1, 9999); // if it does, generate a new ID and check again
            $idExists = Invoice::where('id', $id)->exists();
        }
        return response()->json(['id' => $id]);
    }

    public function show($id) //muestra los tickets
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 500);
        }
    
        return response()->json(['invoice' => $invoice], 200);
        //return view('livewire.invoice-modal')->with('invoice',$invoice);
    }

    public function update(Request $request, string $id) //cambia el estado
    {
        //
        $validatedData = $request->validate([
            'estado' => 'required|integer',
        ]);
    
        // Find the invoice in the database
        $invoice = Invoice::find($id);
    
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 500);
        }
    
        // Update the state of the invoice
        $invoice->estado = $validatedData['estado'];
        $invoice->save();
    
        return response()->json(['message' => 'Invoice state changed successfully'], 200);
    }
}
