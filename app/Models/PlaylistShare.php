<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistShare extends Model
{
    use HasFactory;
    protected $table = 'playlist_shares';
    protected $fillable = ['playlist_id','user_id','provider'];
}
