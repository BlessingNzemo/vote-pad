<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__.'/apiGlody.php';
require __DIR__.'/api_evaluation.php';
require __DIR__.'/api_vote.php';
