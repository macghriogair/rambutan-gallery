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
Route::group([
    'namespace' => 'Read'
], function() {
    Route::get('albums', 'AlbumController@index');
    Route::get('albums/{readAlbum}', 'AlbumController@show');
    Route::get('albums/{readAlbum}/photos', 'AlbumPhotoController@photosByAlbum');

    Route::get('photos', 'PhotoController@index');
    Route::get('photos/{readPhoto}', 'PhotoController@show');
});

Route::group([
    'namespace' => 'Write'
], function() {
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

    Route::post('upload/{mediaType}', 'UploadController@store');
});



