<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Song extends Model
{
    use HasFactory;
    protected $table = 'songs';
    protected $fillable = ['name','slug','artist_name','duration',
    'file','image_cover','viewer','country','mv_id',
    'genre_id','user_id','album_id'];
    public $timestamps = true;
    public function users() {
        return $this->belongsToMany(User::class,'song_likers','song_id','user_id')->withTimestamps();
    }
    public function likers(){
        return $this->hasMany(SongLiker::class);
    }
    public function liked(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->likers()->where('user_id',$user_id);
    }
    public function artists(){
        return $this->hasMany(SongArtist::class);
    }
    public function playlists(){
        return $this->hasMany(PlaylistSong::class);
    }
    public function views(){
        return $this->hasMany(View::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function album(){
        return $this->belongsTo(Album::class);
    }
    public function mv(){
        return $this->belongsTo(Mv::class);
    }
    
}
