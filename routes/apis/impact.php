






<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImpactController;




Route::post("/",[ImpactController::class,'store'])->middleware(['validate.impact']);

Route::post("/{impactId}",[ImpactController::class,'update'])->middleware(['validate.impact']);


Route::middleware(["localize"])->group(function(){

Route::get("/",[ImpactController::class,'index']);


Route::get("/{impactId}",[ImpactController::class,'show']);

});

Route::delete("/{impactId}",[ImpactController::class,'destroy']);