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
    Route::redirect('/', '/admin/posts', 301);
    Route::prefix('posts')->name('post.')->group(function () {
        Route::get('/', 'PostController@index')->name('index');
        Route::post('store', 'PostController@store')->name('store');
        Route::view('create', 'admin.posts.create')->name('create');
        Route::get('{trashed_post}/edit', 'PostController@edit')->name('edit');
        Route::put('{trashed_post}', 'PostController@update')->name('update');
        Route::delete('{post}', 'PostController@destroy')->name('destroy');
        Route::put('/restore/{trashed_post}', 'PostController@restore')->name('restore');
        Route::delete('/delete/{trashed_post}', 'PostController@delete')->name('delete');
    });
});