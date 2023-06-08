<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}', function($token){
    return $token;
})->middleware(['guest:'.config('fortify.guard')])
    ->name('password.reset');

if(\Illuminate\Support\Facades\App::environment('local')){
    Route::get('/playground', function (){
        return (new \App\Mail\WelcomeMail())->render();
    });
}

