<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvLiker extends Model
{
    use HasFactory;
    protected $table = 'mv_likers';
    protected $fillable = ['mv_id','user_id'];
}
