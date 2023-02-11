<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MvResource extends SonginfoResource
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
            'mv'=>new MvsResource($this->mv),
            'user'=>new UserResource($this->user),
        ];
        return array_merge($parent,$array);
    }
}
