<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function getUser(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function getPhoto(){
        return $this->hasOne(Photo::class,"article_id");
    }

    public function getPhotos(){
        return $this->hasMany(Photo::class);
    }
}
