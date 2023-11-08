<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserClient extends Model
{
    use HasFactory;
    protected $table='user_client';
    protected $fillable=[
        'client_id',
        'user_id'
    ];
    public function client(){
        return $this->belongsTo('user_client','user_id');
    }
    
    public function user(){
        return $this->belongsTo('user_client','client_id');
    }
}
