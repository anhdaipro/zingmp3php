<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SongsResource;
use App\Models\Song;
use App\Models\SongLiker;
class GenreResource extends JsonResource
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
            'updated_at'=>$this->updated_at,
            'created_at'=>$this->created_at,
            'songs'=>SongsResource::collection($this->songs),
        ];
        $id=$this->id;
        $number_likers=SongLiker::whereRelation('song','genre_id',$this->id)->count();
        $array['number_likers']=$number_likers;
        return $array;
    }
}
