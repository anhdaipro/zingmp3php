<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistFollower extends Model
{
    use HasFactory;
    protected $table='artist_followers';
    protected $fillable =['artist_id','user_id'];
    public function followers(){
        return $this->hasMany(ArtistFollower::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
