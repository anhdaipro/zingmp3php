<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CommentDisliker;
use APp\Models\CommentLiker;
use App\Http\Controller\Api\UserController;
class CommentResource extends JsonResource
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
            'id'=>$this->id,
            'body'=>$this->body,
            'user'=>new UserResource($this->user),
            'count_likers'=>$this->likers->count(),
            'count_dislikers'=>$this->dislikers->count(),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
        $liked=$this->liked()->exists()?true:false;
        $array['liked']=$liked;
        $disliked=$this->disliked()->exists()?true:false;
        $array['disliked']=$disliked;
        return $array;
    
   
    }
}
