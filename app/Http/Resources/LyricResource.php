<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LyricResource extends JsonResource
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
            'lyrics'=>$this->lyrics,
            'sentences'=>json_decode($this->sentences,true),
        ];
        return $array;
    }
}
