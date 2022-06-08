<?php

use Ll\llcms\http\Controllers;
use Illuminate\Support\Facades\Route;

Route::resource('cms-articles', Controllers\ArticleController::class);
Route::resource('cms-tags', Controllers\TagController::class);
Route::resource('cms-category', Controllers\CategoryController::class);
