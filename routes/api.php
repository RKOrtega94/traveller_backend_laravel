<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application.
|
*/
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'getAll'); // GET /api/users
    Route::post('/users', 'create'); // POST /api/users
    Route::get('/users/{id}', 'show'); // GET /api/users/{id}
    Route::put('/users/{id}', 'update'); // PUT /api/users/{id}
    Route::delete('/users/{id}', 'delete'); // DELETE /api/users/{id}
});
