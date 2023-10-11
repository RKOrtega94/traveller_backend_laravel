<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TouristSpotController;
use App\Http\Controllers\Api\TouristTypeController;
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

/*
|--------------------------------------------------------------------------
|   Role Routes
|--------------------------------------------------------------------------
|
| Here is where you can register role routes for your application.
 */
Route::controller(RoleController::class)->group(function () {
    Route::get('/roles', 'getAll'); // GET /api/roles
    Route::get('/roles/{id}', 'getRole'); // GET /api/roles/{id}
    Route::post('/roles', 'create'); // POST /api/roles
    Route::put('/roles/{id}', 'update'); // PUT /api/roles/{id}
    Route::delete('/roles/{id}', 'delete'); // DELETE /api/roles/{id}
});

/*
|--------------------------------------------------------------------------
|   Tourist Spot Routes
|--------------------------------------------------------------------------
|
| Here is where you can register tourist spot routes for your application.
*/
Route::controller(TouristSpotController::class)->group(function () {
    Route::get('/tourist-spots', 'getAll'); // GET /api/tourist-spots
    Route::get('/tourist-spots/{id}', 'show'); // GET /api/tourist-spots/{id}
    Route::post('/tourist-spots', 'create'); // POST /api/tourist-spots
    Route::put('/tourist-spots/{id}', 'update'); // PUT /api/tourist-spots/{id}
    Route::delete('/tourist-spots/{id}', 'delete'); // DELETE /api/tourist-spots/{id}
});

/*
|--------------------------------------------------------------------------
|   Location Routes
|--------------------------------------------------------------------------
|
| Here is where you can register location routes for your application.
*/

Route::controller(LocationController::class)->group(function () {
    Route::get('/locations', 'getAll'); // GET /api/locations
    Route::get('/locations/{id}', 'show'); // GET /api/locations/{id}
    Route::post('/locations', 'create'); // POST /api/locations
    Route::put('/locations/{id}', 'update'); // PUT /api/locations/{id}
    Route::delete('/locations/{id}', 'delete'); // DELETE /api/locations/{id}
});

/*
|--------------------------------------------------------------------------
|   Category Routes
|--------------------------------------------------------------------------
|
| Here is where you can register category routes for your application.
*/
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'getAll'); // GET /api/categories
    Route::get('/categories/{id}', 'show'); // GET /api/categories/{id}
    Route::post('/categories', 'create'); // POST /api/categories
    Route::put('/categories/{id}', 'update'); // PUT /api/categories/{id}
    Route::delete('/categories/{id}', 'delete'); // DELETE /api/categories/{id}
});

/*
|--------------------------------------------------------------------------
|   Tourist Type Routes
|--------------------------------------------------------------------------
|
| Here is where you can register tourist type routes for your application.
*/
Route::controller(TouristTypeController::class)->group(function () {
    Route::get('/tourist-types', 'getAll'); // GET /api/tourist-types
    Route::get('/tourist-types/{id}', 'show'); // GET /api/tourist-types/{id}
    Route::post('/tourist-types', 'create'); // POST /api/tourist-types
    Route::put('/tourist-types/{id}', 'update'); // PUT /api/tourist-types/{id}
    Route::delete('/tourist-types/{id}', 'delete'); // DELETE /api/tourist-types/{id}
});
