<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaylistLiker extends Model
{
    use HasFactory;
    protected $table = 'playlist_likers';
    protected $fillable = ['playlist_id','user_id'];
}
