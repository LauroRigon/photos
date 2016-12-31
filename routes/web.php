<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::auth();

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'admin'], function () {

    /*
     * Photos
     * */
    //create photo
    Route::get('photo/create', 'PhotoController@create');
    Route::post('photo/create', 'PhotoController@store');

    //delete photo
    Route::delete('photo/delete/{photoID}', 'PhotoController@destroy');

    //update photo
    Route::put('photo/update/{photoID}', 'PhotoController@update');

    /*
     * Albums
     * */
    Route::get('album/create', 'AlbumController@create');

    Route::post('album/create', 'AlbumController@store');

    Route::get('album/delete', 'AlbumController@delete');
    Route::delete('album/delete/{albumID}', 'AlbumController@destroy');

    /*
     * Users
     * */
    Route::post('user/create', 'UserController@store');

    Route::delete('user/delete/{userID}', 'UserController@destroy');

    Route::put('user/update/{userID}', 'UserController@update');
});

Route::group(['prefix' => 'userarea'], function () {
    //Route::get('/',);
    /*
     * Photos
     */
    //Get a thumbnail of the photo
    Route::get('photos/get/{filemane}', 'PhotoController@get');

    //delete photo
    Route::delete('photos/delete/{photoID}', 'PhotoController@destroy');

    /*
     * Albums
     * */
    Route::delete('album/delete/{albumID}', 'AlbumController@destroy');

    Route::delete('album/delete/{albumID}', 'AlbumController@destroy');
});