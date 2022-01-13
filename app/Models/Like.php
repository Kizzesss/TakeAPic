<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //use HasFactory;
    protected $table = "likes";

    //Relacion Muchos a Uno Users
    public function user(){
        return $this->belongsTo(User::class, 'user_id');

    }

    //Relacion Muchos a Uno Images
    public function image(){
        return $this->belongsTo(Image::class, 'image_id');
    }
}
