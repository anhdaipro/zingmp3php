<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLiker extends Model
{
    use HasFactory;
    protected $table='comment_likers';
    protected $fillable =['comment_id','user_id'];
    function comment(){
        return $this->belongsTo(Comment::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
