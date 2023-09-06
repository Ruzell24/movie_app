<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [UserController::class, 'login']);
Route::post('/sign-up', [UserController::class, 'store']);

Route::get('/movies', [MovieController::class, 'getMovies']);


Route::group(['middleware' => ['auth:sanctum']] , function () {
    Route::post('/bookmark-movie' , [MovieController::class , 'bookmarkMovie']);
    Route::get('/get-bookmark-movie-list' , [MovieController::class, 'getMovieBookmark']);
});
   
