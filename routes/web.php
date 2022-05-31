<?php

use App\Auth\AuthController;
use App\Models\Module as normalModule;
use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;

Route::get('/', function () {
    return view('app');
});

Route::get('/code', function () {
    return view('code.show');
});
