




<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;




Route::post("/",[CompanyController::class,'store'])->middleware(['validate.company']);


Route::middleware(["localize"])->group(function(){


Route::get("/",[CompanyController::class,'index']);

Route::get("/{companyId}",[CompanyController::class,'show']);

});

Route::post("/{companyId}",[CompanyController::class,'update'])->middleware(['validate.company']);

Route::delete("/{companyId}",[CompanyController::class,'destroy']);