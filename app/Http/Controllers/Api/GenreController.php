<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Http\Resources\GenresResource;
use App\Models\Genre;
class GenreController extends Controller
{
    public function genres(){
        $genres= GenresResource::collection(Genre::with(['songs','songs.album','songs.artists.artist'])->offset(0)->limit(10)->get());
        return response()->json($genres);
    }
    public function genre($slug){
        try{
            $genre= new GenreResource(Genre::where('slug',$slug)->first());
            return response()->json($genre);
        }
        catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage(),'status'=>500]);
        }
    }
}
