<?php

use Illuminate\Support\Facades\Route;

Route::get('/manager', 'HomeController@index');
Route::get('/rekap', 'RekapController@index')->name('rekap.index');
Route::post('/rekap/cari', 'RekapController@cari')->name('rekap.cari');
// Route::get('/rekap/print', 'RekapController@printPDF')->name('rekap.print');
Route::post('/rekap/import', 'RekapController@import')->name('rekap.import');
Route::get('/rekap/export', 'RekapController@export')->name('rekap.export');

Route::resource('/barang', 'BarangController');
Route::resource('/kategori', 'CategoryController');