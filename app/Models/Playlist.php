<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;
    protected $table = 'playlists';
    protected $fillable = ['name','user_id','slug','ramdom_play','public'];
    public function songs(){
        return $this->hasMany(PlaylistSong::class);
    }
    public function likers(){
        return $this->hasMany(PlaylistLiker::class);
    }
    public function liked(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->likers()->where('user_id',$user_id);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
