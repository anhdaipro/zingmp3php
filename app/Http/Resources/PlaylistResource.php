<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Song;
class PlaylistResource extends PlaylistsResource
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
            'user'=>new UserResource($this->user),
            'songs'=>SongsResource::collection(Song::whereRelation('playlists', 'playlist_id', $this->id)->get())
        ];
        return array_merge($parent,$array);
    }
}
