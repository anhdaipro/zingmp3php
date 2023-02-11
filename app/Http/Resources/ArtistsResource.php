<?php

namespace App\Http\Resources;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ArtistFollower;
use App\Models\Song;
class ArtistsResource extends ArtistinfoResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $parent=parent::toArray($request);
        $array=[
            'updated_at'=>$this->updated_at,
            'songs'=>SonginfoResource::collection(Song::whereRelation('artists', 'artist_id', $this->id)->where('created_at','>',date("Y-m-d",strtotime("-30 day")))->get())
        ];
        return array_merge($parent,$array);
    }
}
