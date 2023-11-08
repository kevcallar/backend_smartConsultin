<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Adviser;
use App\Models\UserAdviser;
use App\Mail\remainderEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Notifications\ResetPassword;

class AdviserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{   
    $advisers = Adviser::all();
    
    if(!$advisers){
        return response()->json(['error'=>'No advisers where found'],500);
    }
    return view('backoffice.index', compact('advisers'));
}

    public function getAdvisers(){
        $advisers=Adviser::all('id','name','surname','email');
        if(!$advisers){
            return response()->json(['error'=>'no advisers where found'],500);
        }
        return response()->json([
            'advisers'=>$advisers
        ],200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('advisers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'surname'=>'required|max:255',
            'email'=>'required|email|unique:advisers,email',
        ]);

        if($validatedData->fails()){
            return response()->json(['errors' => $validatedData->errors()], 500);
        }
        //se guarda en asesor
        $adviser = new Adviser;

        if($adviser->email == $request->email){
            return response()->json(['errors' => 'email already exists'], 400);
        }
        $adviser->name = $request->input('name');
        $adviser->email = $request->input('email');
        $adviser->surname = $request->input('surname');
        $adviser->password=''; //no se puede dejar null
        $adviser->save();

        //se guarda en usuarios
        $user=User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => '',
            'is_super_admin' => false,
            'type'=>1
        ]);

        //se guarda en la tabla relacional user_adviser
        $user_adviser=UserAdviser::create([
            'user_id'=>$user->id,
            'adviser_id'=>$adviser->id
        ]);

        Password::sendResetLink(['email'=>$request->input('email')]);

         return redirect()->route('backoffice')
             ->with('success', 'Adviser created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function showClients($id)
    {
        //
        $adviser=Adviser::find($id);
        if(!$adviser){
            return response()->json(['error'=>'no advisers where found'],500);
        }
        
        $client=$adviser->client;
        if($client->isEmpty()){
            return response()->json(['error'=>'no clients where found for this advisers'],500);
        }
        return response()->json([
            'client'=>$client
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $adviser=Adviser::findOrFail($id);
        return view('livewire.edit-modal', compact('adviser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adviser $adviser)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:advisers,email,'.$adviser->id,
            'surname' => 'required',
            // Add other validation rules for other fields
        ]);
    
        $adviser->name = $request->name;
        if ($adviser->email !== $request->email) {
            $adviser->email = $request->email;
        }
        $adviser->surname=$request->surname;
        // Update other fields as necessary
        
    
        $adviser->save();
    
        return redirect()->route('backoffice')
                         ->with('success', 'Adviser updated successfully.');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adviser $adviser)
    {
        //
        if ($adviser->client()->count() > 0) {
            session()->flash('error', 'El asesor seleccionado no se puede eliminar porque tiene asesores asignados.');
        }

        else{
            $userAdviser=UserAdviser::where('adviser_id',$adviser->id)->first();
            $user=User::where('id',$userAdviser->user_id)->first();
            $adviser->delete(); 
            $user->delete();
            session()->flash('success','El asesor se ha eliminado correctamente');
        }

        return redirect()->route('backoffice');
    }


    public function sendReminder()
{
    // Retrieve the adviser's clients
    $userId=Auth::user()->id;
    $adviser=UserAdviser::where('user_id',$userId)->first();
    $adviserId=$adviser->adviser_id;
    $clients = Client::where('adviser_id',$adviserId)->get();

    // Check if the adviser has clients
    if ($clients->isEmpty()) {
        return response()->json(['error' => 'No se han encontrado clientes.'], 500);
    }

    // Send a reminder email to each client
    foreach ($clients as $client) {
        Mail::to($client->email)->send(new remainderEmail($client));
    }
    session()->flash('success','Se ha enviado un correo a todos los clientes');

    // Return a success response
    //return response()->json(['message' => 'Reminder emails sent successfully.'], 200);
    return redirect()->route('adviser.index',['clients'=>$clients]);
}
}
