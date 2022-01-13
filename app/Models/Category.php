<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    public function user(){
        return $this->hasMany(User::class);
    }

    public function image(){
        return $this->hasMany(Image::class);
    }
}
