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

// Guest Area
Route::get('/', 'Guest\HomeController@index');
Route::get('post', function () {
    return redirect('/');
});

Route::get('post/{blog}', 'Guest\BlogsController@single');
Route::get('category/{category}', 'Guest\BlogsController@category');
Route::post('post/comment', 'Guest\BlogsController@comment');

Route::post('subscribe', 'Guest\HomeController@subscribe');
Route::get('subscribe/verify/{token}', 'Guest\HomeController@subscribeVerify');

Route::get('feed', 'FeedsController@index');

// User Area
Auth::routes();
Route::get('auth/verify/{token}', 'Auth\RegisterController@verify');

// Admin Area
Route::get('/home', 'HomeController@index')->name('home')->middleware('role:dashboard');

Route::get('unauthorized', function () {
    return view('unauthorized');
});

Route::resource('admin/blogs', 'Admin\BlogsController');
Route::resource('admin/comments', 'Admin\CommentsController', ['except' => [
    'create', 'store'
]]);
Route::resource('admin/users', 'Admin\UsersController');
Route::resource('admin/roles', 'Admin\RolesController', ['except' => [
    'create', 'store', 'update', 'destroy', 'edit'
]]);
Route::resource('admin/settings', 'Admin\SettingsController', ['except' => [
    'create', 'store', 'destroy'
]]);
