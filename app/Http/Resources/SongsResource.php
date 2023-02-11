<?php

namespace App\Http\Resources;
use App\Models\Song;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\SongLiker;
use App\Http\Controllers\Api\UserController;
class SongsResource extends SonginfoResource
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
        $user=new UserController();
        $user_id=$user->getAuthenticatedUser();
        $liked=$this->liked()->exists();
        $parent['liked']=$liked;
        return $parent;
    }
}
