<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Mv extends Model
{
    use HasFactory;
    protected $table = 'mvs';
    protected $fillable = ['name','file','file_preview','duration'];
    
    public function likers() {
        return $this->hasMany(MvLiker::class);
    }
   
    public function liked(){
        $user_id=0;
        if(auth()->user()){
            $user_id=auth()->user()->id;
        }
        return $this->likers()->where('user_id',$user_id);
    }
}


