<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/prodi', function () {
    return view('master.prodi.index')->name('prodi.index');
});
