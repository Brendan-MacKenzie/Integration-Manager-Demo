<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/client-credential', [PageController::class, 'clientCredentialTest']);
Route::get('/authorization', [PageController::class, 'authorizationTest']);
Route::get('/integration/callback', [PageController::class, 'authorizationRedirect']);
