<?php

namespace App\Http\Controllers\Api;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SongDashBoardResource;
use App\Models\Song;

class DashboardController extends Controller
{
    public function dashboard(){
        $a=5;
        $songs=DB::select('select songs.id,count(views.song_id) from songs
        left join song_views as views on views.song_id=songs.id 
        where views.updated_at >= DATE_SUB(NOW(),INTERVAL 1 DAY)
        group by songs.id
        order by count(views.song_id) desc limit 20');
        $array=[];
        foreach ($songs as $song) {
            $array[] =$song->id;
        }
        $top10=SongDashBoardResource::collection(Song::whereIn('id',$array)->get()->sortByDesc('views'));
        $dashboard=DB::select('select songs.id,songs.name,songs.duration,songs.artist_name,
        STR_TO_DATE(song_views.updated_at,"%Y-%m-%d %H") as day,
        count(song_views.song_id) as views from (select songs.id,name,duration,artist_name,count(views.song_id) as count from songs
        left join song_views as views on views.song_id=songs.id 
        where views.updated_at >= DATE_SUB(NOW(),INTERVAL 1 DAY)
        group by songs.id
        order by count desc limit 3) as songs
        left join song_views as song_views on song_views.song_id=songs.id 
        where song_views.updated_at > DATE_SUB(NOW(),INTERVAL 1 DAY)
        group by songs.id,STR_TO_DATE(song_views.updated_at,"%Y-%m-%d %H")');
        return response()->json(['dashboard'=>$dashboard,'top10'=>$top10]);
    }
}
