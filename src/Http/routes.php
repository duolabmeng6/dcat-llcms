<?php

use Ll\llcms\http\Controllers;
use Illuminate\Support\Facades\Route;

Route::resource('articles', Controllers\ArticleController::class);
Route::resource('tags', Controllers\TagController::class);
