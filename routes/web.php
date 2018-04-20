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

Route::get('/', 'PostController@index')->name('post.index');
Route::get('posts/{post}', 'PostController@show')->name('post.show');

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    Route::prefix('posts')->name('post.')->group(function () {
        Route::get('/', 'PostController@index')->name('index');
        Route::post('store', 'PostController@store')->name('store');
        Route::view('create', 'admin.posts.create')->name('create');
        Route::get('{post}/edit', 'PostController@edit')->name('edit');
        Route::put('{post}', 'PostController@update')->name('update');
    });
});