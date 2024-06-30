<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/api/google_auth.php', [ App\Http\Controllers\ServicesAuthController::class, 'googleAuth' ])->name('google_auth');

Route::group(['namespace' => 'App\Http\Controllers' ], function(){

    Route::get('/questions', 'QuestionController@index')->name('questions.index');
    Route::get('/categories', 'CategoryController@index')->name('categories.index');

    // Route::middleware(['auth'])->group( function() {

        Route::group(['prefix' => 'categories', 'controller' => 'CategoryController'], function(){

            Route::name('category.')->group(function(){
                Route::get('/detail/{category}/', 'detail')->name('detail');
                Route::get('/add', 'add')->name('add');
                Route::post('/', 'store')->name('store');
            });
        }); 

        Route::group(['prefix' => 'questions', 'controller' => 'QuestionController'], function(){

            Route::name('question.')->group(function(){
                Route::get('/detail/{question}/', 'detail')->name('detail');
                Route::get('/add', 'add')->name('add');
                Route::post('/', 'store')->name('store');
            });
        });

        Route::group(['prefix' => 'comments', 'controller' => 'CommentController'], function(){

            Route::name('comment.')->group(function(){
                Route::post('/', 'store')->name('store');
            });
        });

    // });

    Route::post('/ajax/setThemeMode', 'UserController@setThemeMode')->name('setThemeMode');
    
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');