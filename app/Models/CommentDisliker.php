<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentDisliker extends Model
{
    use HasFactory;
    protected $table='comment_dislikers';
    protected $fillable =['comment_id','user_id'];
    function comment(){
        return $this->belongsTo(Comment::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
