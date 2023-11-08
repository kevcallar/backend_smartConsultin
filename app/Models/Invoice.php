<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table='invoice';

    protected $filable=[
        'client_id',
        'cifCliente',
        'nombre',
        'fecha',
        'desc',
        'precioUnitario',
        'precioTotal',
        'iva',
        'precioFinal'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
