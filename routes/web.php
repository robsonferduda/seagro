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

Route::get('conteudo/{nome}','App\Http\Controllers\PaginaController@buscar');

Route::get('eventos/pesencial/sessao-solene-alesc','App\Http\Controllers\PaginaController@evento');

Route::get('destaque/{nome}','App\Http\Controllers\PaginaController@destaque');

Route::post('email/contato','App\Http\Controllers\EmailController@contato');