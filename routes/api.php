<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReturningController;
use App\Http\Controllers\UnitItemController; 
use App\Http\Controllers\UsedItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
   Route::apiResources([
      'users'       => UserController::class,
      'categories'  => CategoryController::class,
      'locations'   => LocationController::class,
      'items'       => ItemController::class,
      'unit-items'  => UnitItemController::class,
      'borrowings'  => BorrowingController::class,
      'returnings'  => ReturningController::class,
      'used-items'  => UsedItemController::class,
      'logs'        => LogController::class,
   ]);
});

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/unit-items', [UnitItemController::class, 'index']);

   Route::prefix('borrowings')->group(function () {
      Route::get('/', [BorrowingController::class, 'index']);
      Route::get('/show/{id}', [BorrowingController::class, 'show']);
      Route::post('/', [BorrowingController::class, 'store']);
   });
   
   Route::prefix('returnings')->group(function () {
      Route::get('/', [ReturningController::class, 'index']);
      Route::get('/show/{id}', [ReturningController::class, 'show']);
      Route::post('/', [ReturningController::class, 'store']);
   });
});