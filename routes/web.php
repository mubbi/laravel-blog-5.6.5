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

Route::get('search', 'Guest\BlogsController@search');
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

// Admin Routes
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard')->middleware('role:dashboard');

    // Blogs
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

    // Categories
    Route::get('categories/bulk/delete', 'Admin\CategoriesController@bulkDelete')->name('categories.bulkDelete');
    Route::get('categories/ajax-select', 'Admin\CategoriesController@categoriesAjaxSelectData')->name('categories.ajaxSelectData');
    Route::get('categoriesData', 'Admin\CategoriesController@categoriesData')->name('categories.ajaxData');
    Route::resource('categories', 'Admin\CategoriesController');

    // Comments
    Route::get('commentsData', 'Admin\CommentsController@commentsData')->name('comments.ajaxData');
    Route::get('comments/bulk/delete', 'Admin\CommentsController@bulkDelete')->name('comments.bulkDelete');
    Route::get('comments/bulk/spam', 'Admin\CommentsController@bulkSpam')->name('comments.bulkSpam');
    Route::get('comments/spam/status/{id}', 'Admin\CommentsController@updateSpamStatus')->name('comments.spamStatus');
    Route::resource('comments', 'Admin\CommentsController', ['except' => [
        'create', 'store'
    ]]);

    // Users
    Route::get('usersData', 'Admin\UsersController@usersData')->name('users.ajaxData');
    Route::get('users/bulk/delete', 'Admin\UsersController@bulkDelete')->name('users.bulkDelete');
    Route::get('users/active/status/{id}', 'Admin\UsersController@updateActiveStatus')->name('users.activeStatus');
    Route::get('users/roles/{id}/edit', 'Admin\UsersController@editRoles')->name('users.editRoles');
    Route::put('users/roles/{id}', 'Admin\UsersController@updateRoles')->name('users.updateRoles');
    Route::resource('users', 'Admin\UsersController');

    // Settings
    Route::get('settings', 'Admin\SettingsController@index')->name('settings.index');
    Route::put('settings/update', 'Admin\SettingsController@update')->name('settings.update');

    // Subscribers
    Route::get('subscribers/active/{id}', 'Admin\SubscribersController@updateActiveStatus')->name('subscribers.activeStatus');
    Route::get('subscribersData', 'Admin\SubscribersController@subscribersData')->name('subscribers.ajaxData');
    Route::resource('subscribers', 'Admin\SubscribersController', ['except' => [
        'create', 'store', 'show'
    ]]);
});
