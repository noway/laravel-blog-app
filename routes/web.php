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

Route::get('/', 'BlogController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts', 'PostsController@index')->name('posts');
Route::get('/posts/create', 'PostsController@showPostCreationForm')->name('posts-create');
Route::post('/posts/create', 'PostsController@create');
Route::get('/posts/{slug}/delete', 'PostsController@delete');
Route::get('/posts/{slug}/edit', 'PostsController@showPostEditForm');
Route::post('/posts/{slug}/edit', 'PostsController@edit')->name('posts-edit');
