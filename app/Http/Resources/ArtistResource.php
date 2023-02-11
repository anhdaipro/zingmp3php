<?php

namespace App\Http\Resources;
use App\Http\Resources\SongsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Api\UserController;
use App\Models\Song;
class ArtistResource extends ArtistsResource
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
        $choice=$request->get('choice');
        $songs=Song::whereRelation('artists', 'artist_id', $this->id)->where('created_at','>',date("Y-m-d",strtotime("-60 day")))->get();
        if ($choice=='mv'){
            $songs=$songs.whereNotNull('mv_id');
        }
        if ($choice=='singer'){
            $songs=$songs.whereNotNull('album_id');
        }
        $parent['songs']=SongsResource::collection($songs);
        return $parent;
    }
}
