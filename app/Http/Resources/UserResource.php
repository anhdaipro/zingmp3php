<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $array= [
            'id' => $this->id,
            'name' => $this->name,
            'avatar'=>$this->avatar,
            'username'=>$this->username,
            
        ];
        $array['singer']=$this->artist?true:false;
        return $array;
    }
}
