





<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;


Route::middleware(["validate.project"])->group(function(){


Route::post("/",[ProjectController::class,'store']);

Route::post("/{projectId}",[ProjectController::class,'update']);


});

Route::middleware(["localize"])->group(function(){

Route::get("/",[ProjectController::class,'index']);

Route::get("/{projectId}",[ProjectController::class,'show']);

});


Route::delete("/{projectId}",[ProjectController::class,'destroy']);
