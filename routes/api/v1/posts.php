<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('heyaa')
    ->name('posts.')
    ->group(function (){
        Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/posts/{post}', [\App\Http\Controllers\PostController::class, 'show'])
            ->name('show')
            ->withoutMiddleware('auth');

        Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])
            ->name('store')
            ->withoutMiddleware('auth');

        Route::patch('/posts/{post}', [\App\Http\Controllers\PostController::class, 'update'])
            ->name('update')
            ->withoutMiddleware('auth');

        Route::delete('/posts/{post}', [\App\Http\Controllers\PostController::class, 'destroy'])
            ->name('destroy')
            ->withoutMiddleware('auth');

    });
