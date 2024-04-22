<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;


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

//adminLogin
Route::post('/adminLogin',[AdminController::class,'adminLogin']);


//setGame
Route::post('/setGame',[AdminController::class,'SetGame']);

//admin add team
Route::post('/addTeam',[AdminController::class,'AddTeam']);

//admin add player
Route::post('/addPlayer',[AdminController::class,'AddPlayer']);

//admin start game
Route::post('/StartGame',[AdminController::class,'StartGame']);