<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::group(['middleware' => ['web']], function() {

    Route::get('/', function () {
    return view('welcome');
    })->name('home');
    
    Route::post('/signup',[
        'uses' => 'UserController@postSignUp',
        'as' => 'signup'
    ]);
    
    Route::post('/signin',[
        'uses' => 'UserController@postSignIn',
        'as' => 'signin'
    ]);
    
    Route::get('/dashboard',[
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard',
        'middleware' => 'auth' //only authority user can access dashboard
    ]);
    
    //route for create post
    Route::post('/createpost',[
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create',
        'middleware' => 'auth'
    ]);
    
    //route for log out
    Route::get('/logout',[
        'uses' => 'UserController@getLogout',
        'as' => 'logout'
    ]);
    
    //route for delete post
    Route::get('/delete-post/{post_id}',[
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete',
        'middleware' => 'auth'
    
    ]);
    
    Route::get('/account', [
        'uses' => 'UserController@getAccount',
        'as' => 'account'
    ]);
    
    Route::post('/updateaccount', [
        'uses' => 'Usercontroller@postSaveAccount',
        'as' => 'account.save'
    ]);
    
    Route::get('/userimage/{filename}',[
        'uses' => 'Usercontroller@getUserImage',
        'as' => 'account.image'
    ]);
    
    Route::post('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);
    
    Route::post('/like',[
        'uses' => 'PostController@postLikePost',
        'as' => 'like'
    ]);
        
});
