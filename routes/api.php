<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::prefix('companies')->group(base_path('routes/apis/company.php'));

Route::prefix('impacts')->group(base_path('routes/apis/impact.php'));

Route::prefix('countries')->group(base_path('routes/apis/country.php'));

Route::prefix('projects')->group(base_path('routes/apis/project.php'));

Route::prefix('partners')->group(base_path('routes/apis/partner.php'));

Route::prefix('themes')->group(base_path('routes/apis/theme.php'));