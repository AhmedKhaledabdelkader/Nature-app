



<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;




Route::middleware(["validate.country"])->group(function(){

Route::post("/",[CountryController::class,'store']);

Route::post("/{countryId}",[CountryController::class,'update']);

});

Route::middleware(["localize"])->group(function(){


Route::get("/",[CountryController::class,'index']);


Route::get("/{countryId}",[CountryController::class,'show']);

});

Route::delete("/{countryId}",[CountryController::class,'destroy']);





