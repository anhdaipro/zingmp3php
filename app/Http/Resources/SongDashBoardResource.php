<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongDashBoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array =[
            'id'=>$this->id,
            'name'=>$this->name,
            'artist_name'=>$this->artist_name,
            'slug'=>$this->slug,
            'image_cover'=>$this->image_cover,
            'duration'=>$this->duration,
            'user'=>new UserResource($this->user),
            'albumn'=>new AlbumResource($this->album),
            'views'=>$this->views->where('updated_at','>=',date("Y-m-d H:m",strtotime("-1 day")))->count(),
            'hasLyric'=>$this->hasLyric,
            'hasKaraoke'=>$this->hasKaraoke,
        ];
        
        return $array;
    }
}
