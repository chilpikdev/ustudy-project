<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('posts', [PostController::class, 'posts']);
