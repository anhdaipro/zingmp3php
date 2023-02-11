<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $table='song_views';
    protected $fillable = [
        'song_id',
        'user_id',
    ];
    public function song(){
        return $this->belongsTo(Song::class);
    }
}
