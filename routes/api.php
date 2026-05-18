<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\TechStackController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\WorkExperienceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductUrlController;

Route::get('/', function (Request $request) {
    return "Well come to our api";
});

Route::prefix('v1')->group(function(){

    Route::prefix('auth')->group(function(){
        route::post('register',[AuthController::class, 'register']);
        route::post('login',[AuthController::class, 'login']);
        route::post('logout',[AuthController::class, 'logout'])->middleware('auth:api');
    });

    Route::middleware('auth:api')->group(function(){

        Route::prefix('accounts/me')->group(function(){
            Route::get('', [AccountController::class, 'me']);
            Route::put('', [AccountController::class, 'update']);
            Route::put('avatar', [AccountController::class, 'uploadAvatar']);

            // manage tool
            Route::get('tools', [AccountController::class, 'getToolByAccount']);
            Route::post('tools', [AccountController::class, 'assignMultipleTools']);
            Route::delete('tool/{tool_id}', [AccountController::class, 'unAssignTool']);

            // manage tech stack
            Route::get('techs', [AccountController::class, 'getTechByAccount']);
            Route::post('techs', [AccountController::class, 'assignMultipleTechs']);
            Route::delete('tech/{tech_id}', [AccountController::class, 'unAssignTech']);

            // manage education
            Route::get('education', [EducationController::class, 'getByAccount']);
            Route::post('education', [EducationController::class, 'store']);
            Route::put('education/{education_id}', [EducationController::class, 'update']);
            Route::delete('education/{education_id}', [EducationController::class, 'destroy']);

            // manage work experience
            Route::get('work-experience', [WorkExperienceController::class, 'getByAccount']);
            Route::post('work-experience', [WorkExperienceController::class, 'store']);
            Route::put('work-experience/{work_experience_id}', [WorkExperienceController::class, 'update']);
            Route::delete('work-experience/{work_experience_id}', [WorkExperienceController::class, 'destroy']);

            // manage product
            Route::get('product',[ProductController::class, 'getByAccount']);
            Route::post('product',[ProductController::class, 'store']);
            Route::put('product/{product_id}',[ProductController::class, 'update']);
            Route::delete('product/{product_id}', [ProductController::class], 'destroy');
            // manage tech stack of product
            Route::post('product/{product_id}/tech',[ProductController::class, 'assignTech']);
            Route::delete('product/{product_id}/tech/{tech_id}',[ProductController::class, 'unAssignTech']);
            // manage urls of product
            Route::post('product/{product_id}/url',[ProductUrlController::class, 'store']);
            Route::put('product/url/{product_url_id}',[ProductUrlController::class, 'update']);
            Route::delete('product/url/{product_url_id',[ProductUrlController::class, 'destroy']);
        });

        Route::apiResource('tools', ToolController::class);

        Route::apiResource('techs', TechStackController::class);

    });

});
