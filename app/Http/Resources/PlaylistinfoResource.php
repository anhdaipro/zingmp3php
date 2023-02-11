<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistinfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'ramdom_play'=>$this->ramdom_play,
            'public'=>$this->public,
            'slug'=>$this->slug
        ];
    }
}
