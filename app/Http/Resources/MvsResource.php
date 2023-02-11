<?php

namespace App\Http\Resources;
use App\Models\MvLiker;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Api\UserController;
class MvsResource extends JsonResource
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
            'file'=>$this->file,
            'file_preview'=>$this->file_preview,
            'duration'=>$this->duration
        ];
        $liked=$this->liked()->exists()?true:false;
        $array['liked']=$liked;
        return $array;
    }
}
