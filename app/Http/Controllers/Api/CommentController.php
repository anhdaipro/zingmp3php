<?php

namespace App\Http\Controllers\Api;
use App\Models\Comment;
use App\Models\CommentLiker;
use App\Models\CommentDisliker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Controller\Api\UserController;
class CommentController extends Controller
{
    public function show($id){
        $comment= Comment::find($id);
        return response()->json([$comment]);
    }
    public function detroy($id){
        Comment::destroy($id);
        return response()->json(['sucess'=>true,'message'=>'Comment had deleted']);
    }
    public function actioncomment(Request $request,$id){
        
        $user_id=auth()->user()->id;
        $comment=Comment::find($id);
        $action=$request->get('action');
        $data=[];
        if ($action=='update'){
            $comment->body=$request->get('body');
            $comment->save();
        }
        else if ($action=='like'){
            $liked=false;
            if ($comment->liked()->exists()){
                $comment->liked()->delete();
            }
            else{
                CommentLiker::create([
                    'comment_id'=>$id,
                    'user_id'=>$user_id
                ]);
                $liked=true;
            }
            $data=['liked'=>$liked,'count_likers'=>$comment->likers->count()];
        }
        else if ($action=='dislike'){
            $disliked=false;
            if ($comment->disliked()->exists()){
                $comment->liked()->delete();
            }
            else{
                CommentDisliker::create([
                    'comment_id'=>$id,
                    'user_id'=>$user_id
                ]);
                $disliked=True;
            }
            $data=['liked'=>$disliked,'count_dislikers'=>$comment->dislikers->count()];
        }
        else if ($action=='reply'){
            $commnentchild=Comment::create(['parent_id'=>$id,'body'=>$body,'user_id'=>$user_id]);
            $data=['id'=>$commentchild->id];
        }
        return response()->json($data);
    }
    public function comments(Request $request){
        $query=Comment::with(['user','likers','dislikers'])->where('post_id',$request->get('post_id'));
        $comments=CommentResource::collection($query->get());
        return response()->json(['comments'=>$comments,'count'=>$query->count()]);
    }
}
