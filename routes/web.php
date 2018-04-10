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

Route::get('/', 'PostController@index');
Route::get('posts/{post}', 'PostController@show')->name('post.show');

Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', 'PostController@index')->name('admin.post.index');
        Route::post('store', 'PostController@store')->name('admin.post.store');
        Route::view('create', 'admin.posts.create')->name('admin.post.create');
    });
});