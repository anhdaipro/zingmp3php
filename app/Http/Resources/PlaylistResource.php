<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Resources\UserResource;
class PlaylistResource extends JsonResource
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
            'songs'=>SongsResource::collection($this->songs->get())
        ];
        return array_merge($parent,$array);
    }
}
