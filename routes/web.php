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

Route::get('/','App\Http\Controllers\HomeController@index');

Route::get('boletim/detalhes/{data}','App\Http\Controllers\PaginaController@getBoletim');
Route::get('boletim/download/{id}','App\Http\Controllers\PaginaController@boletim');

Route::get('contato','App\Http\Controllers\PaginaController@contato');

Route::get('noticia/{url}','App\Http\Controllers\NoticiaController@buscar');
Route::get('noticias','App\Http\Controllers\NoticiaController@index');

Route::get('pagina/{nome}','App\Http\Controllers\PaginaController@buscar');

Route::get('eventos','App\Http\Controllers\EventoController@index');
Route::get('eventos/detalhes/{id}','App\Http\Controllers\EventoController@detalhes');
Route::get('eventos/pesencial/sessao-solene-alesc','App\Http\Controllers\PaginaController@evento');

Route::get('destaque/{nome}','App\Http\Controllers\PaginaController@destaque');

Route::post('email/contato','App\Http\Controllers\EmailController@contato');