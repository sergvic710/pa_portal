<?php

use Illuminate\Support\Facades\Route;

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
//Route::prefix('admin')
//    ->group(function () {
//        Route::get('/',[\App\Http\Controllers\Admin\HomeController::class,'index'])->name('admin.index');
//        Route::name('mews.')
//            ->group(function () {
//                Route::resource('category',\App\Http\Controllers\Admin\CategoryNewsController::class);
//            });
//    });

Route::name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('index');
        Route::name('news.')
            ->prefix('news')
            ->group(function() {
                Route::resource('category',\App\Http\Controllers\Admin\CategoryNewsController::class);
            });
        Route::resource('news',\App\Http\Controllers\Admin\NewsController::class);

//    Route::group(['prefix'=>'news','name'=>'news.'],function (){
//        Route::get('/category',[\App\Http\Controllers\Admin\CategoryNewsController::class,'index'])->name('category.index');
////        Route::resources([
////            'category' => \App\Http\Controllers\Admin\CategoryNewsController::class,
//////            'posts' => PostController::class,
////        ]);
//    });
    });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
