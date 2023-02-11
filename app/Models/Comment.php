<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table='comments';
    
    protected $fillable = [
        'body',
        'parent_id',
        'user_id',
        'song_id',
        'post_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likers(){
        return $this->hasMany(CommentLiker::class);
    }
    public function dislikers(){
        return $this->hasMany(CommentDisliker::class);
    }
    public function liked(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->likers()->where('user_id',  $user_id);
    }
    public function disliked(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->dislikers()->where('user_id',  $user_id);
    }
}
