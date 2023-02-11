<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Api\UserController;
class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        $arr1=[
            'lyrics'=>$this->lyrics,
            'sentences'=>$this->sentences,
            'count_views'=>$this->views->count(),
            'count_comment'=>$this->comments->count(),
        ];
        
        
        return $arr1;
    }
}
