<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Read
Route::get('albums', 'ReadAlbumController@index');
Route::get('albums/{readAlbum}', 'ReadAlbumController@show');

Route::get('photos', 'ReadPhotoController@index');
Route::get('photos/{readPhoto}', 'ReadPhotoController@show');

// Write
Route::post('albums', 'AlbumController@store')
    ->name('album.add');
Route::delete('album/{albumId}', 'AlbumController@destroy')
    ->name('album.destroy');

Route::post('photos', 'PhotoController@store')
    ->name('photo.add');
Route::patch('photos/{photoId}/tag', 'PhotoController@tagPhoto')
    ->name('photo.tag');
Route::patch('photos/{photoId}/untag', 'PhotoController@untagPhoto')
    ->name('photo.untag');
Route::patch('photos/{photoId}/album', 'PhotoController@addToAlbum')
        ->name('photo.addToAlbum');
Route::delete('photos/{photoId}', 'PhotoController@destroy')
    ->name('photo.destroy');

