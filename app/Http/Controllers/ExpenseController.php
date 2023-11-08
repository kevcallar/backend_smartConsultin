<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{

    public function store(Request $request) //guarda la imagen de gasto
    {
        $validatedData = Validator::make($request->all(),[
            'image' => 'required',
            'email'=>'required|email'
        ]);

        if($validatedData->fails()){
            return response()->json(['errors'=>$validatedData->errors()],500);
        }
        
        // Save the image file to storage
        $imageData = $request->input('image');
        $imageName = uniqid() . '.jpg';
        Storage::disk('expenses')->put($imageName, base64_decode($imageData));

        // Create a new expense object
        $expense = new Expense();
        $expense->image = $imageData;
        $client=Client::where('email',$request->input('email'))->first();
        $expense->client_id=$client->id; 
        
        $expense->save();

        return response()->json(['message' => 'Expense stored successfully'], 200);
    }

    public function show(string $id) //muestra la imagen
    {
        $expense = Expense::find($id);
    
        if (!$expense) {
            return response()->json(['error' => 'Image not found'], 500);
        }
    
        $imageData = $expense->image;
        // Decode the base64-encoded image
        $image = base64_decode($imageData);
    
        // Set the appropriate headers for the image
        header('Content-Type: image/jpeg');
    
        // Output the decoded image
        echo $image;
    
        // return view('livewire.expense-modal', [
        //     'expense' => $expense
        // ]);

        return response()->json([$image],200);
    }


    public function update(Request $request, string $id) //actualiza el estado del ticket
    {
        
        $validatedData = $request->validate([
            'state' => 'required|integer',
        ]);
    
        // Find the expense in the database
        $expense = Expense::find($id);
    
        if (!$expense) {
            return response()->json(['error' => 'expense not found'], 500);
        }
    
        // Update the state of the expense
        $expense->state = $validatedData['state'];
        $expense->save();
    
        return response()->json(['message' => 'expense state changed successfully'], 200);
    }


}
