<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\PostLiker;
use App\Models\Comment;
use App\Models\PostShare;
use App\Http\Resources\PostsResource;
use App\Http\Resources\CommentResource;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        

    public function posts(Request $request)
    {
        $choice=$request->get('choice');
        $country=1;
        if($choice=='usuk'){
            $country=2;
        }
        else if($choice=='kpop'){
            $country=3;
        }
        else if($choice=='cpop'){
            $country=4;
        }
        $posts=Post::with('files')->whereRelation('artist','country',$country)->with(['artist','likers','comments'])->limit(10)->get();
        $data=PostsResource::collection($posts);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $caption=$request->get('caption');
        $file=$request->file('file');
        $file_preview=$request->file('file_preview');
        $post=Post::create(['caption'=>$caption,'artist_id'=>auth()->user()->artist->id]);
        $filepost=new PostMedia();
        if($file_preview){
            $filepost->file_preview=cloudinary()->upload($request->file('file_preview')->getRealPath())->getSecurePath();
        }
        $filepost->file=cloudinary()->uploadVideo($request->file('file')->getRealPath())->getSecurePath();
        $filepost->post_id=$post->id;
        $filepost->save();
        return response()->json(['file'=>$filepost->file]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        $data=new PostResource($post);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::find($id);
        $action=$request->get('action');
        $data=['sucess'=>true];
        if ($action=='update'){
            $caption=$request->get('caption');
            $file=$request->file('file');
            $file_id=$request->get('file_id');
            $file_preview=$request.file('file_preview');
            $post->caption=$caption;
            $post->save();
            $filepost=MediaPost::find($file_id);
            if ($file){
                $filepost->file=$file->store('api');
            }
            if ($file_preview){
                $filepost->file_preview=$file_preview->store('api');
            }
            $filepost->save();
        }
        else if ($action=='like'){
            $liked=False;
            if ($post->likers()->exists()){
                $post->likers()->delete();
            }
            else{
                PostLiker::create(['user_id'=>auth()->user()->id,'post_id'=>$id]);
                $liked=True;
            }
            $data['liked']=$liked;
            $data['count_likers']=$post->likers()->count();
        }
        else if ($action=='comment'){
            $body=$request->get('body');
            $comment=Comment::create(['user_id'=>auth()->user()->id,'body'=>$body,'post_id'=>$id]);
            $serializer=new CommentResource($comment);
            $data=$serializer;
        }
        else{
            $provider=$request->get('provider');
            PostShare::create(['post_id'=>$id,'user_id'=>auth()->user()->id,'provider'=>$provider]);
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
    }
}
