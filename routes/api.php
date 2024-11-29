<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('me', function () {
    $user = [
        'name' => "O'lmas",
        'phone' => 998930000001,
        'gender' => 'male'
    ];

    return response()->json($user);
});

Route::get('params', function (Request $request) {
    return response()->json($request->all());
});

Route::get('path/{id}', function ($id) {
    return $id;
});

Route::post('store', function (Request $request) {
    dump($request->param1, $request->param2);
    dd($request->param1, $request->param2);
});

Route::post('login', function (Request $request) {
    return response()->json($request->only(['login', 'password']));
});

Route::post('file', function (Request $request) {
    dd($request);
});

Route::match(['put', 'patch'], 'update', function () {
    return response()->json([
        'message' => "Маглыуматлар жаналанды"
    ]);
});

Route::prefix('posts')->group(function () {
    Route::get('/', fn () => response()->json(['message' => "index page"])); // index
    Route::post('create', fn () => response()->json(['message' => "post created"])); // create
    Route::get('show/{id}', fn () => response()->json(['message' => "post data"])); // show
    Route::match(['put', 'patch'], 'update/{id}', fn () => response()->json(['message' => "post created"])); // update
    Route::delete('delete/{id}', fn () => response()->json(['message' => "post deleted"])); // delete
});
