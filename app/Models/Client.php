<?php

namespace App\Models;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $table='clients';

    protected $fillable=[
        'cif',
        'name',
        'surname',
        'status',
        'password',
        'email',
        'phone',
        'advisor_id'
    ];

    public function adviser()
    {
        return $this->belongsTo(Adviser::class,'adviser_id');
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function UserClient(){
        return $this->belongsTo(UserClient::class,'user_client','client_id');
    }

    public function otp(){
        return $this->hasMany(EmailCode::class);
    }

    public function paginate($id){
        
        $invoices = Invoice::where('client_id', $id)->orderBy('created_at', 'desc')->get();
        
        $expenses = Expense::where('client_id', $id)->orderBy('created_at', 'desc')->get();

        $results=array_merge($invoices->toArray(),$expenses->toArray());
        
        $data=new Paginator($results,2,null,['path'=>url('/clients/'.$id)]);
        return $data;
    }
}
