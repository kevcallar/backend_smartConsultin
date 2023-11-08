<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdviser extends Model
{
    use HasFactory;

    protected $table='user_adviser';
    protected $fillable=[
        'adviser_id',
        'user_id'
    ];
    public function adviser(){
        return $this->belongsTo('user_adviser','user_id');
    }
    
    public function user(){
        return $this->belongsTo('user_adviser','adviser_id');
    }
}
