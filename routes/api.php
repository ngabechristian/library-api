<?php

use App\Http\Controllers\admin\AuthorController;
use App\Http\Controllers\admin\BookController;
use App\Http\Controllers\admin\EditorController;
use App\Http\Controllers\admin\GenreController;
use App\Http\Controllers\admin\SeriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// api/admin

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\admin','middleware' => 'json.response'], function () {
    Route::apiResource('authors',AuthorController::class);
    Route::apiResource('editors',EditorController::class);
    Route::apiResource('genres',GenreController::class);
    Route::apiResource('series',SeriesController::class);
    Route::apiResource('books',BookController::class);


    Route::get('book/sevenDaysBooksTotal',[BookController::class,'getLastSevenDaysBooksTotal']);
    Route::get('book/sevenDaysBooks',[BookController::class,'getLastSevenDaysBooks']);
});
