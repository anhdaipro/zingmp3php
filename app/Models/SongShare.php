<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongShare extends Model
{
    use HasFactory;
    protected $table = 'song_shares';
    protected $fillable = ['song_id','user_id','provider'];
}
