<?php

namespace App\Http\Resources;
use App\Models\Song;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaylistsResource extends PlaylistinfoResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parent= parent::toArray($request);
        $array=[
            'images'=>Song::select('image_cover')->whereRelation('playlists', 'playlist_id', $this->id)->get()
        ];
        return array_merge($parent,$array);
    }
}
