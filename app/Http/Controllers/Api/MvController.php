<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MvsResource;
use App\Http\Resources\MvResource;
use App\Models\Song;
use App\Models\Mv;
use App\Models\MvView;
use App\Models\MvLiker;
class MvController extends Controller
{
    public function mv(Request $request){
        $id=$request->get('id');
        $mv=new  MvsResource(Mv::find($id));
        return response()->json($mv);
    }
    function actionmv(Request $request,$id){
        $action=$request->get('action');
        $data=[];
        $mv=Mv::find($id);
        if ($action=='delete'){
            $mv->delete();
        }
        else if ($action=='view'){
            MvView::create(['user_id'=>auth()->user()->id,'mv_id'=>$id]);
        }
        else if ($action=='like'){
            $liked=False;
            if ($mv->liked()->exists())
                $mv->liked()->delete();
            else{
                MvLiker::create(['user_id'=>auth()->user()->id,'mv_id'=>$id]);
                $liked=True;
            }
            $data['liked']=$liked;
            $data['count_likers']=$mv->likers()->count();
        }
        else if ($action=='comment'){
            $comment=Comment::create(['user_id'=>auth()->user()->id,'mv_id'=>$id,'body'=>$request->get('body')]);
            $data=$comment;
        }
        else{
            ShareMv::create(['user_id'=>auth()->user()->id,'provider'=>$request->get('provider'),'mv_id'=>$id]);
        }
        return response()->json($data);  
        
    }
    function listmv(){
        $songs=Song::whereNotNull('mv_id')->get();
        $data=MvResource::collection($songs);
        return response()->json($data);  
    }
    function uploadmv(Request $request){
        $file=$request->file('file');
        $file_preview=$request->file('file_preview');
        $name=$request->get('name');
        $duration=$request->get('duration');
        Mv::create([
            'file'=>cloudinary()->uploadVideo($request->file('file')->getRealPath())->getSecurePath(),
            'file_preview'=>cloudinary()->upload($request->file('file_preview')->getRealPath())->getSecurePath(),
            'name'=>$name,
            'duration'=>$duration,
        ]);
        return response()->json(['success'=>true]);  
    }
}
