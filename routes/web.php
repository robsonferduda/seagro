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

Auth::routes();

Route::get('gercont','App\Http\Controllers\ConteudoController@index');
Route::get('gercont/boletins','App\Http\Controllers\ConteudoController@boletins');
Route::get('gercont/noticias','App\Http\Controllers\ConteudoController@noticias');
Route::get('gercont/paginas','App\Http\Controllers\ConteudoController@paginas');
Route::get('gercont/videos','App\Http\Controllers\ConteudoController@videos');
Route::resource('boletim','App\Http\Controllers\BoletimController');

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

Route::get('empresas-publicas/{pagina}','App\Http\Controllers\EmpresaController@publicas');
Route::get('empresas-privadas/{pagina}','App\Http\Controllers\EmpresaController@privadas');

Route::get('videos/todos','App\Http\Controllers\VideoController@index');
Route::get('video/{id}/delete','App\Http\Controllers\VideoController@delete');
Route::get('videos/publicacao/atualizar/{id}','App\Http\Controllers\VideoController@atualizar');
Route::resource('video','App\Http\Controllers\VideoController');