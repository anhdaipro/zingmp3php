<?php

namespace App\Http\Resources;
use App\Models\PostMedia;
use Illuminate\Http\Resources\Json\JsonResource;

class PostinfoResource extends JsonResource
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
            'caption'=>$this->caption,
            'files'=>PostMediaResource::collection($this->files),
            'viewer'=>$this->viewer
        ];
        
    }
}
