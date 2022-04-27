<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PhotoController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("")->group(function (){

    Route::get("article",[\App\Http\Controllers\PageController::class,'article'])->name('page.article');
    Route::get("article",[\App\Http\Controllers\PageController::class,'about'])->name('page.about');
    Route::get("article",[\App\Http\Controllers\PageController::class,'contact'])->name('page.contact');

});

Route::prefix("user-dashboard")->middleware("auth")->group(function (){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource("article","App\Http\Controllers\ArticleController");
    Route::resource("photo","App\Http\Controllers\PhotoController");


//    Route::get("search",[ArticleController::class,"search"])->name("article.search");

    Route::get("/profile-edit",[\App\Http\Controllers\ProfileController::class,'edit'])->name("profile.edit");
    Route::post("/profile-store",[\App\Http\Controllers\ProfileController::class,'update'])->name("profile.update");

    Route::post("/profile/changePassword",[\App\Http\Controllers\ProfileController::class,'changePassword'])->name("profile.changePassword");

    Route::get("/use-phone",[\App\Http\Controllers\HomeController::class,'usePhone'])->name("use.phone");

});




Auth::routes();


