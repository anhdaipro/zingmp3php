<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLiker extends Model
{
    use HasFactory;
    protected $table = 'post_likers';
    protected $fillable = ['post_id','user_id'];
}
