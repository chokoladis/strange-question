<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/api/google_auth.php', [ App\Http\Controllers\ServicesAuthController::class, 'googleAuth' ])->name('google_auth');
Route::get('/api/yandex_auth.php', [ App\Http\Controllers\ServicesAuthController::class, 'yandexAuth' ])->name('yandex_auth');
Route::get('/api/telegram_auth.php', [ App\Http\Controllers\ServicesAuthController::class, 'telegramAuth' ])->name('telegram_auth');

Route::group(['namespace' => 'App\Http\Controllers' ], function(){

    Route::get('/questions', 'QuestionController@index')->name('questions.index');
    Route::get('/categories', 'CategoryController@index')->name('categories.index');
    Route::get('/categories/detail/{category}/', 'CategoryController@detail')->name('categories.detail');
    Route::get('/questions/detail/{question}/', 'QuestionController@detail')->name('questions.detail');

     Route::middleware(['auth'])->group( function() {

        Route::group(['prefix' => 'questions', 'controller' => 'QuestionController'], function(){
            Route::name('questions.')->group(function(){
                Route::get('/add', 'add')->name('add');
                Route::post('/', 'store')->name('store');
            });
        });

        Route::group(['prefix' => 'comments', 'controller' => 'CommentController'], function(){
            Route::name('comments.')->group(function(){
                Route::post('/', 'store')->name('store');
            });
        });

//        admin

         Route::middleware(['admin'])->group( function() {

             Route::group(['prefix' => 'categories', 'controller' => 'CategoryController'], function() {
                 Route::name('categories.')->group(function () {
                     Route::get('/add', 'add')->name('add');
                     Route::post('/', 'store')->name('store');
                 });
             });
         });

     });
    Route::post('/feedback', 'FeedbackController@store')->name('feedback.store');

    Route::post('/ajax/setThemeMode', 'UserController@setThemeMode')->name('setThemeMode');

});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');