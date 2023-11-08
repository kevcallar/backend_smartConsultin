<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
    use HasFactory;

    protected $table = 'advisers';

    protected $fillable=[
        'surname',
        'name',
        'email',
    ];

    public function client(){
        return $this->hasMany(Client::class, 'adviser_id');
    }

    public function userAdviser(){
        return $this->belongsTo(UserAdviser::class,'user_adviser','adviser_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
