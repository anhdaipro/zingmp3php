<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SonginfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array=[
            'id'=>$this->id,
            'name'=>$this->name,
            'artist_name'=>$this->artist_name,
            'slug'=>$this->slug,
            'image_cover'=>$this->image_cover,
            'duration'=>$this->duration,
            'count_likers'=>$this->likers->count(),
            'artists'=>$this->artists->count(),
            'album'=>new AlbumResource($this->album),
            'hasLyric'=>$this->hasLyric,
            'hasKaraoke'=>$this->hasKaraoke,
            'created_at'=>$this->created_at,
            'video'=>$this->mv
        ];
        return $array;
    }
}
