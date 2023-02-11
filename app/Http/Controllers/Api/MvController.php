<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resource\MvResource;
use App\Models\Song;
use App\Models\Mv;
use App\Models\MvView;
use App\Models\MvLiker;
class MvController extends Controller
{
    public function video(){
        $id=$request->get('id')
        $mv=new  MvsResource(Mv::find($id));
        return response()->json($mv);
    }
    function actionmv(Request $request,$id){
        $action=$request->get('action');
        $data=[];
        $mv=Mv::find($id)
        if ($action=='delete'){
            $mv->delete();
        }
        else if ($action=='view'){
            MvViews::create(['user_id'=>$user_id,'mv_id'=>$id]);
        }
        else if ($action=='like'){
            $liked=False;
            if $mv->likers->exists():
                $mv->likers->delete();
            else:
                MvLiker::create(['user_id'=>auth()->user(),'mv_id'=>$id]);
                $liked=True;
            }
            $data['liked']=$liked;
            $data['count_likers']=$mv->likers()->count();
        }
        else if ($action=='comment'){
            $comment=Comment::create(['user_id'=>$user_id,'mv_id'=>$id,'body'=>$request->get('body')]);
            $data[]=$comment->attributesToArray();
        }
        else{
            ShareMv::create(['user_id'=>$user_id,'provider'=>$request->get('provider'),'mv_id'=>$id]);
        }
        return response()->json($data);  
        
    }
    function listmv(){
        $songs=Song::whereNotNull('mv')->get();
        $data=MvResource::collection($songs);
        return response()->json($data);  
    }
    function uploadmv(Request $request){
        $file=$request->file('file');
        $file_preview=$request->file('file_preview');
        $name=$request->get('name');
        $duration=$request->get('duration');
        Mv::create([
            'file'=>$file->store('api'),
            'file_preview'=>$file_preview->store('api'),
            'name'=>$name,
            'duration'=>$duration,
        ]);
        return response()->json(['success'=>true]);  
    }
}
