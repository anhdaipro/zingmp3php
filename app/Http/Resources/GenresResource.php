<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Song;
use App\Models\Artist;
class GenresResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array= [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'songs'=>SongsResource::collection(Song::with(['album'])->where('genre_id',$this->id)->orderBy('id', 'desc')->limit(1)->get()),
        ];
        
        $artists=Artist::with(['songs','songs.song'=>function ($query){
            $query->where('genre_id',$this->id);
        }])->limit(4)->get();
        $array['artirsts']=$artists;
        return $array;
    }
}
