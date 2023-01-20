<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CatImagenesController;
use App\Http\Controllers\LoginController;

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

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::post('/tokens/create', function (Request $request) {

    $token = $request->user()->createToken('auth_token');

    return ['token' => $token->plainTextToken];
});

Route::apiResource('imagenes', CatImagenesController::class)->middleware(['auth:sanctum', 'cors']);
