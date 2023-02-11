<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvShare extends Model
{
    use HasFactory;
    protected $table = 'mv_shares';
    protected $fillable = ['mv_id','user_id','provider'];
}
