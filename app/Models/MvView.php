<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MvView extends Model
{
    use HasFactory;
    protected $table = 'mv_views';
    protected $fillable = ['mv_id','user_id'];
}
