<?php

namespace App\Http\Resources;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ArtistFollower;
class ArtistinfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user=new UserController();
        $user_id=$user->getAuthenticatedUser();
        $array=[
            'id'=>$this->id,
            'image'=>$this->user->avatar,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'number_followeres'=>$this->followers->count()
        ];
        $followed=$this->followed()->exists()?true:false;
        $array['followed']=$followed;
        return $array;
        
    }
}
