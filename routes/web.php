<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CircuitosController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('circuitos', CircuitosController::class);
