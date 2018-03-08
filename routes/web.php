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
Route::get('unauthorized', function () {
    return view('unauthorized');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('role:dashboard');

    Route::get('blogsData', 'Admin\BlogsController@blogsData')->name('blogs.ajaxData');
    Route::get('blogs/bulk/trash', 'Admin\BlogsController@bulkTrash')->name('blogs.bulkTrash');
    Route::get('blogs/bulk/restore', 'Admin\BlogsController@bulkRestore')->name('blogs.bulkRestore');
    Route::get('blogs/trashed', 'Admin\BlogsController@trashed')->name('blogs.trashedData');
    Route::get('blogsTrashedData', 'Admin\BlogsController@blogsAjaxTrashedData')->name('blogs.ajaxTrashedData');
    Route::get('blogs/restore/{id}', 'Admin\BlogsController@restore')->name('blogs.restore');
    Route::get('blogs/delet/permanent/{id}', 'Admin\BlogsController@permanentDelet')->name('blogs.permanentDelet');
    Route::get('blogs/trash/empty', 'Admin\BlogsController@emptyTrash')->name('blogs.emptyTrash');
    Route::get('blogs/publish/status/{id}', 'Admin\BlogsController@updateActiveStatus')->name('blogs.publishStatus');
    Route::resource('blogs', 'Admin\BlogsController');

    Route::get('categories/bulk/delete', 'Admin\CategoriesController@bulkDelete')->name('categories.bulkDelete');
    Route::get('categories/ajax-select', 'Admin\CategoriesController@categoriesAjaxSelectData')->name('categories.ajaxSelectData');
    Route::get('categoriesData', 'Admin\CategoriesController@categoriesData')->name('categories.ajaxData');
    Route::resource('categories', 'Admin\CategoriesController');

    Route::get('commentsData', 'Admin\CommentsController@commentsData')->name('comments.ajaxData');
    Route::get('comments/bulk/delete', 'Admin\CommentsController@bulkDelete')->name('comments.bulkDelete');
    Route::get('comments/bulk/spam', 'Admin\CommentsController@bulkSpam')->name('comments.bulkSpam');
    Route::get('comments/spam/status/{id}', 'Admin\CommentsController@updateSpamStatus')->name('comments.spamStatus');
    Route::resource('comments', 'Admin\CommentsController', ['except' => [
        'create', 'store'
    ]]);

    Route::get('usersData', 'Admin\UsersController@usersData')->name('users.ajaxData');
    Route::resource('users', 'Admin\UsersController');

    Route::get('settingsData', 'Admin\SettingsController@settingsData')->name('settings.ajaxData');
    Route::resource('settings', 'Admin\SettingsController', ['except' => [
        'create', 'store', 'destroy'
    ]]);
});
