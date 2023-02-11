<?php

namespace App\Http\Resources;
use App\Http\Resources\SongsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Api\UserController;
use App\Models\Song;
use App\Models\Playlist;
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
        $id=$this->id;
        if ($choice=='album'){
            $playlists=Playlist::with(['songs.song.artists'=>function($query) use($id){
                $query->where('artist_id',$id);
            }])->distinct()->get();
            $parent['songs']=[];
            $parent['playlists']=PlaylistResource::collection($playlists);
        }
        else{
            $songs=Song::whereRelation('artists', 'artist_id', $this->id)->where('created_at','>',date("Y-m-d",strtotime("-60 day")))->get();
            if ($choice=='mv'){
                $songs=$songs->whereNotNull('mv_id');
            }
            else if ($choice=='singer'){
                $songs=$songs->whereNotNull('album_id');
            }
            $parent['songs']=SongsResource::collection($songs);
            $parent['playlists']=[];
        }
        
        return $parent;
    }
}
