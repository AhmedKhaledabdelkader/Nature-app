
<?php

use App\Http\Controllers\Api\MediaController;
use Illuminate\Support\Facades\Route;





Route::get('/{filename}', [MediaController::class, 'show'])
    ->where('filename', '.*');
