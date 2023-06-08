<?php
//Route::apiResource('users', \App\Http\Controllers\UserController::class);

use Illuminate\Support\Facades\Route;

Route::middleware([
//    'auth',
//    \App\Http\Middleware\RedirectIfAuthenticated::class,
])
    ->prefix('heyaa')
    ->name('users.')
    ->group(function (){
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');

        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])
            ->name('show')
//            ->where('id', '[0-9]+');
            ->whereNumber('id')
            ->withoutMiddleware('auth');

        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])
            ->name('store')
            ->withoutMiddleware('auth');

        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])
            ->name('update')
            ->withoutMiddleware('auth');

        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])
            ->name('destroy')
            ->withoutMiddleware('auth');

    });
