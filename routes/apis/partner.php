


<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PartnerController;


Route::middleware(["validate.partner"])->group(function(){


Route::post("/",[PartnerController::class,'store']);

Route::post("/{partnerId}",[PartnerController::class,'update']);


});

Route::middleware(["localize"])->group(function(){

Route::get("/",[PartnerController::class,'index']);

Route::get("/{partnerId}",[PartnerController::class,'show']);

});


Route::delete("/{partnerId}",[PartnerController::class,'destroy']);