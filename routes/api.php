<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AboutCategoryController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\FoodCategoryController;
use App\Http\Controllers\Api\FoodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // About 相關路由
    Route::get('abouts', [AboutController::class, 'index']);
    Route::get('abouts/{about}', [AboutController::class, 'show']);
    Route::get('abouts/category/{categoryId}', [AboutController::class, 'getByCategory']);

    // About Category 相關路由
    Route::get('about-categories', [AboutCategoryController::class, 'index']);
    Route::get('about-categories/{category}', [AboutCategoryController::class, 'show']);
    Route::get('about-categories/{category}/children', [AboutCategoryController::class, 'getChildren']);

    // Food 相關路由
    Route::get('foods', [FoodController::class, 'index']);
    Route::get('foods/{food}', [FoodController::class, 'show']);
    Route::get('foods/category/{categoryId}', [FoodController::class, 'getByCategory']);

    // Food Category 相關路由
    Route::get('food-categories', [FoodCategoryController::class, 'index']);
    Route::get('food-categories/{category}', [FoodCategoryController::class, 'show']);
});
