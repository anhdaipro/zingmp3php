<?php

namespace App\Http\Controllers\Api;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Song;
use App\Models\View;
use App\Models\SongShare;
use App\Models\Comment;
use App\Models\SongLiker;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SongResource;
use App\Http\Resources\SongsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LyricResource;
use Illuminate\Support\Facades\Cache;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs= SongsResource::collection(Song::with(['album','likers','artists'])->offset(0)->limit(20)->get());
        return response()->json($songs);
    }
    public function newsongs(Request $request){
        $offset=0;
        
        if($request->has("offset")){
            $offset=$request->get('offset');
        }
        $songs=SongsResource::collection(Song::with(['album','likers','artists'])->where('created_at','>',date("Y-m-d",strtotime("-30 day")))->offset($offset)->limit(20)->get());
        if($request->has('filter')){
            $country=1;
            if($request->get('filter')=='vpop'){
                $country=1;
            }
            else if($request->get('filter')=='usuk'){
                $country=2;
            }
            else if($request->get('filter')=='kpop'){
                $country=3;
            }
            else{
                $country=1;
            }
           
            $songs=$songs->where('country',$country);
        }
        return response()->json($songs);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
        $song=new Song();
        $song->name=$request->get('song_name');
        $song->user_id=auth()->user()->id;
        $song->artist_name=$request->get('artist_name');
        $song->duration=$request->get('duration');
        $song->file=cloudinary()->uploadVideo($request->file('file')->getRealPath())->getSecurePath();
        $song->slug=Str::slug($request->get('name'));
        $song->viewer=1;
        $song->country=1;
        if($request->has('image_cover')){
            $song->image_cover=cloudinary()->upload($request->file('image_cover')->getRealPath())->getSecurePath();
        }
        if($request->has('genre_name')){
            $genre=Genre::firstOrCreate([
                'name'=>$request->get('genre_name'),
                'slug'=>Str::slug($request->get('genre_name'))
            ]);
            $song->genre_id=$genre->id;
        }
        if($request->has('album_name') && $request->get('album_name')!='undefined'){
            $album=Album::firstOrCreate([
                'name'=>$request->get('album_name'),
                'slug'=>Str::slug($request->get('album_name'))
            ]);
            $song->album_id=$album->id;
        }
        $song->save();
        return response()->json([
            'status'=> 200,
            'message'=> 'Song created successfully',  
            ]);
        }
        catch (\Exception $e) {

            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function actionsong(Request $request,$id){
        try{
            $song=Song::find($id);   
            $action=$request->get('action');
            $data=['sucess'=>true];
            $user=new UserController();
            $user_id=$user->getAuthenticatedUser();
            if ($action=='view'){
                View::create(['song_id'=>$id,'user_id'=>$user_id]);
            }
            else if ($action=='like'){
                $songliker=SongLiker::where('song_id',$id)->where('user_id',$user_id);
                if($songliker->count()){
                    $songliker->delete();
                }
                else{
                    SongLiker::create(['song_id'=>$id,'user_id'=>$user_id]);
                }
            }
            else if ($action=='update'){
                $artist_name=$request->get('artist_name');
                $country=$request->get('country');
                $name=$request->get('name');
                $lyrics=$request->get('lyrics');
                if ($request->has('$image_cover')){
                    $song->image_cover=$request.file('image_cover');
                }
                $song->name=$name;
                $song->country=$country;
                if ($request->has('lyrics')){
                    $song->lyrics=$lyrics;
                }
                $song->artist_name=$artist_name;
                $song->save();
            }
            else if ($action=='comment'){
                $body=$request->get('body');
                $comment=Comment::create(['user_id'=>$user_id,'body'=>$body,'song_id'=>$id]);
                $data[]=new CommentResource($comment);
            }
            else{
                $provider=$request->get('provider');
                SongShare::create(['song_id'=>$id,'user_id'=>$user_id,'provider'=>$provider]);
            }
            return response()->json($data);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $song=new SongResource(Song::find($id));
        return response()->json($song);
    }
    public function get_streaming($id){
        return response()->json(Song::select('file')->find($id));
    }
    public function get_lyrics(Request $request){
        return new LyricResource(Song::find($request->get('id')));
    }
    public function songuser(Request $request){
        try{
            $user=new UserController();
            
            $user_id = $user->getAuthenticatedUser();
            $choice=$request->get('choice');
            $songs=$choice=='liked'?Song::whereHas('likers', function ($query) use ($user_id) {
                $query->where('user_id',$user_id);
            })->get():Song::where('user_id',$user_id)->get();
            $data=SongsResource::collection($songs);
            return response()->json($data);
        }
        catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>500]);
        }
        
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
        $song=Song::find($id);   
        if ($request->has('lyrics')){
            $song->lyrics=$request->get('lyrics');
            $song->hasLyric=true;
        }
        if ($request->has('sentences')){
            $song->sentences=$request->get('sentences');
            $song->hasLyric=true;
            $song->hasKaraoke=true;
        }
        $song->save();
        return response()->json(['sucess'=>true]);
    }

    public function updatelyric(Request $request){
        $id = $request->get('id');
        $data=[];
        $item=Song::where('id',$id)->first();
        
        $item->sentences= $request->get('sentences');
        $item->save();
            
        
        return response()->json(['sucess'=>true,]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Song::destroy($id);
        return response()->json(['sucess'=>true,'message'=>'Song had deleted']);
    }
}
