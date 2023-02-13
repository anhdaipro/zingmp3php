<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistSong extends Model
{
    use HasFactory;
    protected $table = 'playlist_songs';
    protected $fillable = ['song_id','playlist_id'];
    public function playlist(){
        return $this->belongsTo(Playlist::class);
    }
    public function song(){
        return $this->belongsTo(Song::class);
    }
    public function artist(){
        return $this->belongsTo(Artist::class);
    }
}
