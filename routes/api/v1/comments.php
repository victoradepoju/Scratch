<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('heyaa')
    ->name('comments.')
    ->group(function (){
        Route::get('/comments', [\App\Http\Controllers\CommentController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/comments/{id}', [\App\Http\Controllers\CommentController::class, 'show'])
            ->name('show')
            ->withoutMiddleware('auth');

        Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])
            ->name('store')
            ->withoutMiddleware('auth');

        Route::patch('/comments/{id}', [\App\Http\Controllers\CommentController::class, 'update'])
            ->name('update')
            ->withoutMiddleware('auth');

        Route::delete('/comments/{id}', [\App\Http\Controllers\CommentController::class, 'destroy'])
            ->name('destroy')
            ->withoutMiddleware('auth');

    });
