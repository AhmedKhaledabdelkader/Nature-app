








<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ThemeController;


Route::middleware(["validate.theme"])->group(function(){


Route::post("/",[ThemeController::class,'store']);

Route::post("/{themeId}",[ThemeController::class,'update']);


});

Route::middleware(["localize"])->group(function(){

Route::get("/",[ThemeController::class,'index']);

Route::get("/{themeId}",[ThemeController::class,'show']);

});


Route::delete("/{themeId}",[ThemeController::class,'destroy']);
