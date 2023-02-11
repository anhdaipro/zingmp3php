<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PostLiker;
use App\Http\Controller\Api\UserController;
class PostsResource extends PostinfoResource

{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        $parrent= parent::toArray($request);
        $array=[
            'updated_at'=>$this->updated_at,
            'artist'=>$this->artist,
            'count_likers'=>$this->likers->count(),
            'count_comments'=>$this->comments->count(),
        ];
        $liked=$this->liked()->exists()?true:false;
        $array['liked']=$liked;
        return array_merge($parrent,$array);
    }
}
