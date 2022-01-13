<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //use HasFactory;
    protected $table = "images";

    //Relacion Uno a Muchos Comments
    public function comment(){
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    //Relacion Uno a Muchos Likes
    public function like(){
        return $this->hasMany(Like::class);
    }

    //Relacion Muchos a Uno Users
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    //Relacion Muchos a Uno Category
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
