<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table='expense';
    protected $fillable=[
        'state',
        'image',
        'client_id'
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
