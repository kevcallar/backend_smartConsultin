<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCode extends Model
{
    use HasFactory;

    protected $table='email_code';

    protected $fillable=[
        'otp',
        'client_id'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
