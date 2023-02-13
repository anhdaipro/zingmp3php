<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ArtistinfoResource;
use App\Http\Resources\SonginfoResource;
use App\Http\Resources\SongsResource;
use App\Http\Resources\PlaylistsResource;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Playlist;
class SearchController extends Controller
{
    public function search(Request $request){
        $keyword=$request->get('keyword');
        $artists=ArtistinfoResource::collection(Artist::where('name','like',$keyword.'%')->get());
        $songs=SonginfoResource::collection(Song::where('name','like',$keyword.'%')->get());
        $data=['songs'=>$songs,'artists'=>$artists];
        return response()->json($data);
    }
    public function searchitem(Request $request){
        $keyword=$request->get('keyword');
        $choice=$request->get('choice');
        $offset=$request->get('offset');
        $data=[];
        $songs=Song::with(['album','likers','artists'])->whereHas('artists.artist',function($query) use($keyword){
            $query->where('name','like',$keyword.'%');
        })->orWhere('name','like',$keyword.'%')->distinct()->limit(6)->get();
        $artists=Artist::withwhereHas('songs',function($query) use($keyword){
            $query->where('name','like',$keyword.'%');
        })->orWhere('name','like',$keyword.'%')->distinct()->limit(4)->get();
        
        $playlists=Playlist::withwhereHas('songs.song',function($query) use($keyword){
            $query->where('name','like',$keyword.'%');
        })->orWhere('name','like',$keyword.'%')->distinct()->limit(4)->get();
        $combilesongs=$songs;
        $combileartists=$artists;
        $combileplaylists=$playlists;
        if ($choice=='all'){
            $data=[
            'songs'=>SongsResource::collection($combilesongs),
            'playlists'=>PlaylistsResource::collection($combileplaylists),
            'artists'=>ArtistinfoResource::collection($combileartists),
            ];
        }
        else if ($choice=='song')
            $data=[
            'playlists'=>null,
            'artists'=>null,
            'songs'=>SongsResource::collection($combilesongs),
            ];
        else if ($choice=='playlist'){
            $data=[
                'playlists'=>PlaylistsResource::collection($combileplaylists),
                'artists'=>null,
                'songs'=>null,
                ];
        }
        else if ($choice=='artist'){
            $data=[
                'playlists'=>null,
                'artists'=>ArtistinfoResource::collection($combileartists),
                'songs'=>null,
                ];
        }
        else{
            $data=[
                'playlists'=>null,
                'artists'=>null,
                'songs'=>SongsResource::collection($combilesongs),
                ];
        }
        return response()->json($data);
    }
}
