<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','App\Http\Controllers\PaginaController@index');

Route::get('conteudo/{nome}','PaginaController@buscar');

Route::get('destaque/boletim','PaginaController@destaque');

Route::post('email/contato','App\Http\Controllers\EmailController@contato');