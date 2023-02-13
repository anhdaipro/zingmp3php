<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\MvController;
use App\Http\Controllers\Api\DashboardController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*\DB::listen(function($query) {
    var_dump($query->sql);
});*/
Route::post('v1/signup', [UserController::class,'register']);
Route::post('v1/login', [UserController::class,'login']);
Route::post('v1/refresh', [UserController::class,'refresh']);
Route::get('v1/user/info', [UserController::class,'userinfo']);
Route::get('v1/profile', [UserController::class,'userinfo']);
Route::post('v1/profile', [UserController::class,'update']);
Route::post('v1/oauth/login', [UserController::class,'sociallogin']);
Route::post('v1/auth/email', [UserController::class,'veryfiemail']);
Route::post('v1/auth/phone', [UserController::class,'veryfiphone']);
#song
Route::post('v1/uploadsong', [SongController::class,'store']);
Route::get('v1/songs', [SongController::class,'index']);
Route::get('v1/songs/new', [SongController::class,'newsongs']);
Route::get('v1/song/{id}', [SongController::class,'show']);
Route::post('v1/song/{id}', [SongController::class,'actionsong']);
Route::get('v1/streaming/{id}', [SongController::class,'get_streaming']);
Route::get('v1/lyric', [SongController::class,'get_lyrics']);
Route::get('v1/user/songs', [SongController::class,'songuser']);
Route::post('v1/songs/update', [SongController::class,'updatelyric']);
#video
Route::get('v1/mv', [MvController::class,'mv']);
Route::get('v1/listmv', [MvController::class,'listmv']);
Route::post('v1/upload/video', [MvController::class,'uploadmv']);
Route::post('v1/mv/{id}', [MvController::class,'actionmv']);
Route::post('v1/mvs/insert', [MvController::class,'insertmv']);
#artist
Route::get('v1/artist/{slug}', [ArtistController::class,'artist']);
Route::get('v1/artists', [ArtistController::class,'artists']);
Route::post('v1/artist/{id}', [ArtistController::class,'actionartist']);
Route::get('v1/artistinfo', [ArtistController::class,'artistinfo']);
#genre
Route::get('v1/genre/{slug}', [GenreController::class,'genre']);
Route::get('v1/genres', [GenreController::class,'genres']);

#playlist
Route::get('v1/playlist/{id}', [PlaylistController::class,'playlist']);
Route::post('v1/playlist/{id}', [PlaylistController::class,'actionplaylist']);
Route::get('v1/playlists', [PlaylistController::class,'playlists']);
Route::post('v1/playlist/new', [PlaylistController::class,'addplaylist']);

#post
Route::get('v1/post/{id}', [PostController::class,'post']);
Route::get('v1/posts', [PostController::class,'posts']);
Route::post('v1/uploadpost', [PostController::class,'store']);
Route::post('v1/post/{id}', [PostController::class,'update']);
#comment
Route::get('v1/comment/{id}', [CommentController::class,'comment']);
Route::post('v1/comment/{id}', [CommentController::class,'actioncomment']);
Route::get('v1/comments', [CommentController::class,'comments']);

#seach
Route::get('v1/search/item', [SearchController::class,'searchitem']);
Route::get('v1/search', [SearchController::class,'search']);
#zingchart
Route::get('v1/zingchart', [DashboardController::class,'dashboard']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

