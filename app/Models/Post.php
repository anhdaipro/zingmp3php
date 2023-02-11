<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = ['caption','artist_id'];
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function files(){
        return $this->hasMany(PostMedia::class);
    }
    public function artist(){
        return $this->belongsTo(Artist::class);
    }
    public function likers(){
        return $this->hasMany(PostLiker::class);
    }
    public function liked(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->likers()->where('user_id',$user_id);
    }
}
