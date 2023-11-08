<?php

namespace App\Http\Controllers;


use ZipArchive;
use App\Models\User;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\EmailCode;
use App\Mail\activateUser;
use App\Models\UserClient;
use App\Models\UserAdviser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationClient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public bool $activado=false;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId=Auth::user()->id;
        $adviser=UserAdviser::where('user_id',$userId)->first();
        $adviserId=$adviser->adviser_id;
        $clients = Client::where('adviser_id',$adviserId)->paginate(10);

        return view('advisers.index',['clients'=>$clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //api crear cliente
    {
    //
    $validatedData=Validator::make($request->all(),[
        'cif'=>'unique:clients,cif|string|required',
        'name'=>'string|required',
        'surname'=>'string|required',
        'email'=>'email|required|unique:clients,email',
        'mobile'=>'integer|required',
        'advisor'=>'integer|exists:advisers,id|required',
        'password'=>'string|required',
        'logo'=>'string|nullable'
    ]);
    
    $user=User::where('email',$request->input('email'))->first();

    if($user){//si el user/cliente tiene el email enviado, devuelve 400
        return response()->json(['errors' => 'El email ya ha sido tomado'], 400);
    }

    $cif=Client::where('cif',$request->input('cif'))->first();
    
    if($cif){
        return response()->json(['errors' => 'El CIF ya ha sido tomado'],400);
    }

    if($validatedData->fails()){
        return response()->json(['errors' => $validatedData->errors()], 500);
    }

    $client=new Client;

    $client->cif=$request->input('cif');
    $client->name=$request->input('name');
    $client->surname=$request->input('surname');
    $client->email=$request->input('email');
    $client->phone=$request->input('mobile');
    $client->adviser_id=$request->input('advisor');
    $client->password=Hash::make($request->input('password'));
    $client->status='inactivo';
    $client->logo=$request->input('logo');


    $client->save();


    $user=User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'is_super_admin' => false,
        'type'=>2
    ]);


    $user_client=UserClient::create([
        'user_id'=>$user->id,
        'client_id'=>$client->id
    ]);

    
    

    return response()->json(['success' => 'Client created'], 200);

    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) //api mostrar documentos del cliente segun el id
    {
        $client = Client::find($id);
        
        if(!$client){
            return response()->json(['error'=>'no se ha encontrado al cliente'],500);
        }
        
         $expenses = Expense::where('client_id', $id)->orderBy('created_at', 'desc')->get();

         $invoices = Invoice::where('client_id', $id)->orderBy('created_at', 'desc')->get();

        return view('clients.show', [
            'client' => $client,
            'invoices'=>$invoices,
            'expenses'=>$expenses
        ],200);
    }

    public function showInvoices($id){
        $client = Client::find($id);
        
        if(!$client){
            return response()->json(['error'=>'no se ha encontrado al cliente']);
        }
        $invoices = Invoice::where('client_id', $id)->orderBy('created_at', 'desc')->paginate(5);

        return view('clients.invoices',[
            'invoices'=>$invoices,
            'client'=>$client
        ]);
    }

    
    public function showExpenses($id){
        $client = Client::find($id);
        
        if(!$client){
            return response()->json(['error'=>'no se ha encontrado al cliente']);
        }
        $expenses = Expense::where('client_id', $id)->orderBy('created_at', 'desc')->paginate(5);

        return view('clients.expenses',[
            'expenses'=>$expenses,
            'client'=>$client
        ]);
    }

    public function showDocuments($id)
    {
        $client = Client::find($id);
        
    
        if (!$client) {
            return response()->json(['error' => 'Client not found'], 500);
        }
    
        $expenses = $client->expenses;
        $invoices=$client->invoices;
        return response()->json([
            'expense'=>$expenses,
            'invoice'=>$invoices
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function login(Request $request){ //api de login para clientes 

        $client = Client::where('email', $request->input('email'))->first();
            
        if (!$client) {
            return response()->json(['error'=>'No se ha encontrado al cliente'],404);
        }
        if (!Hash::check($request->input('password'), $client->password)) {
            return response()->json(['errors'=>'La contraseña no coincide'],500);
        }
        
        return response()->json(['success' => 'se ha iniciado sesión'], 200);
    }

public function download($id) { 

    $invoices=Invoice::where('client_id',$id)->get();
    $expenses=Expense::where('client_id',$id)->get();
    $zip = new ZipArchive;
    $a = mt_rand(1, 100);
    $fileName = 'documents_'.$id.'_'.$a.'.zip';
    $zipPath = storage_path('app/public/' . $fileName);
    $zip->open($zipPath, ZipArchive::CREATE);

    foreach ($invoices as $invoice) {
        $filePath = storage_path('app/public/invoices/' . $invoice->id . '.pdf');
        if (file_exists($filePath)) {
            $zip->addFile($filePath, 'gasto_' . $invoice->id . '.pdf');
        }
    }


    foreach ($expenses as $expense) {
        $imageData = base64_decode($expense->image);
        $fileName = 'factura_' . $expense->id . '_' . uniqid() . '.png';
        $filePath = storage_path('app/public/expenses/' . $fileName);
        file_put_contents($filePath, $imageData);
        if (file_exists($filePath)) {
            $zip->addFile($filePath, $fileName);
        }
    }
    $zip->close();
    
    return response()->download($zipPath);
}

public function sendCode(Request $request){ //api para usar en la app

    $client=Client::where('email',$request->input('email'))->first();

    if(!$client){
        return response()->json(['error'=>'No se ha encontrado el correo'],404);
    }

        $status=Mail::to($request->input('email'))->send(new EmailVerificationClient($client));

    if(!$status){ //Verifica si se ha enviado el mail, si no se envia status de 500, si se envia 200
        return response()->json(['error'=>'Ha habido un error'],500);
    }

    return response()->json(['success'=>'Se ha enviado el mail'],200);


}
public function activateUser(Request $request) //putActivateUser FIXME: en principio deberia estar
    {
       $code=EmailCode::where('otp',$request->input('otp'))->first();

    if(!$code){
        return response()->json(['error'=>' no se ha encontrado el codigo'],500);
    }
    $client=Client::where('id',$code->client_id)->first();
    if(!$client){
        return response()->json(['errors'=>'No client was found with this id'],404);
      }
      $client->status='activo';
      $client->save();
    
    EmailCode::where('client_id',$client->id)->delete();

      return response()->json(['success'=>'La cuenta se ha activado'],200);
    }


public function checkEmailCode(Request $request){
    
    $code=EmailCode::where('otp',$request->input('otp'))->first();

    if(!$code){
        return response()->json(['error'=>' no se ha encontrado el codigo'],500);
    }
    $client=Client::where('id',$code->client_id)->first();
    if(!$client){
        return response()->json(['error'=>'No se ha encontrado al cliente']);
    }
    EmailCode::where('client_id',$client->id)->delete();
    return response()->json(['success'=>'El codigo es valido'],200);
}

public function putResetPassword(Request $request){ //api para resetear la contraseña, 
    
    $client=Client::where('email',$request->input('email'))->first();

    if(!$client){
        return response()->json(['error'=>'No se ha encontrado el correo'],404);
    }

    $client->password=Hash::make($request->input('password'));
    $client->save();

    if(!$client->save()){
        return response()->json(['error'=>'Error inesperado'],500);    
    }

    return response()->json(['success'=>'Se ha cambiado la contraseña'],204); //no se si debe devolver status 204 o 200

}
}    
