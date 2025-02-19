<?php

use Illuminate\Support\Facades\Route;

Route::prefix('core/v1')->group(base_path('routes/core/api_v1.php'));
Route::prefix('admin/v1')->group(base_path('routes/admin/api_v1.php'));
