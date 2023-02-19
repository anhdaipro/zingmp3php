<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\ArtistFollower;
use App\Http\Resources\ArtistinfoResource;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\ArtistsResource;
class ArtistController extends Controller
{
    public function artists(){
        $artists =ArtistinfoResource::collection(Artist::with(['user','followers','songs'])->offset(0)->limit(10)->get());
        return response()->json($artists);
    }
    public function artist($slug){
        $artist =new ArtistResource(Artist::where('slug',$slug)->first());
        return response()->json($artist);
    }
    public function artistinfo($id){
        $artist=new ArtistsResource(Artist::find($id));
        return response()->json($artist);
    }
    public function actionartist(Request $request,$id){
        $artist=Artist::find($id);
        $action=$request->get('action');
        if ($action=='follow'){
            if ($artist->followed()->exists()){
                $artist->followed()->delete();
            }
            else{
                ArtistFollower::create([
                    'user_id'=>auth()->user()->id,
                    'artist_id'=>$id
                ]);
            }
        }
        else{
            $name=$request->get('name');
            $description=$request->get('description');
            $artist->name=$name;
            $artist->description=$description;
            $artist->save();
        }
        return response()->json(['succes'=>true]);
    }
}
