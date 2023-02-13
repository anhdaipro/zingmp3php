<?php

namespace App\Http\Controllers\Api;
use App\Models\Playlist;
use App\Models\PlaylistSong;
use App\Models\PlaylistLiker;
use App\Models\Comment;
use App\Models\Artist;
use App\Models\SharePlaylist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PlaylistResource;
use App\Http\Resources\PlaylistsResource;
class PlaylistController extends Controller
{
    public function playlists(){
        $playlists= PlaylistsResource::collection(Playlist::with(['user','songs.song'])->offset(0)->limit(10)->get());
        return response()->json($playlists);
    }
    public function playlist($id){
        $playlist= new PlaylistResource(Artist::find($id));
        return response()->json($playlist);
    }
    public function addplaylist(Request $request){
        $playlist=Playlist::create([
            'user_id'=>auth()->user()->id,
            'slug'=>$request->get('slug'),
            'name'=>$request->get('name'),
            'public'=>$request->get('public'),
            'ramdom_play'=>$request->get('ramdom_play'),
        ]);
        return response()->json($playlist);
    }
    public function actionplaylist(Request $request,$id){
        $data=['sucess'=>true];
        $playlist=Playlist::find($id);
        $action=$request->get('action');
        $songs=$request->get('songs',[]);
        $user_id=auth()->user()->id;
        if ($action=='update'){
            $playlist->name=$request->get('name');
            $playlist->public=$request->get('public');
            $playlist->ramdom_play=$request->get('ramdom_play');
            $playlist->save();
        }
        else if ($action=='addsong'){
            $data=[];
            foreach($songs as $item){
                $playlistsong=new PlaylistSong();
                $playlistsong->song_id=$item;
                $playlistsong->playlist_id=$id;
                if(PlaylistSong::where([['playlist_id',$id],['song_id',$item]])->doesntExist()){
                    $data[]=$playlistsong->attributesToArray();
                }
            }
            PlaylistSong::insert($data);
        }
        else if ($action=='delete'){
            $playlist->delete();
        }
        else if ($action=='like'){
            $liked=False;
            if ($playlist->likers->exists()){
                $playlist->likers->delete();
            }
            else{
                PlaylistLiker::create(['user_id'=>auth()->user(),'playlist_id'=>$id]);
                $liked=True;
            }
            $data['liked']=$liked;
            $data['count_likers']=$playlist->likers()->count();
        }
        else if ($action=='comment'){
            $comment=Comment::create(['user_id'=>$user_id,'playlist_id'=>$id,'body'=>$request->get('body')]);
            $data[]=$comment->attributesToArray();
        }
        else{
            SharePlaylist::create(['user_id'=>$user_id,'provider'=>$request->get('provider'),'playlist_id'=>$id]);
        }
        return response()->json($data);
    }
    public function destroy($id){
        Playlist::destroy($id);
    }
}

