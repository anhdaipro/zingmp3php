<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    protected $table='artists';
    protected $fillable =['id','name','slug','description','user_id'];
    public function songs(){
        return $this->hasMany(SongArtist::class);
    }
    public function followers(){
        return $this->hasMany(ArtistFollower::class);
    }
    public function followed(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->followers()->where('user_id',$user_id);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
