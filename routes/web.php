<?php

use Illuminate\Support\Facades\Route;

Route::get('/manager', 'HomeController@index');
Route::get('/rekap', 'RekapController@index');
Route::post('/rekap/cari', 'RekapController@cari')->name('rekap.cari');
Route::get('/rekap/print', 'RekapController@printPDF')->name('rekap.print');
Route::resource('/barang', 'BarangController');
Route::resource('/kategori', 'CategoryController');