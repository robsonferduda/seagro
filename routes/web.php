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

Auth::routes(['register' => false]);

Route::get('gercont','App\Http\Controllers\ConteudoController@index');
Route::get('gercont/boletins','App\Http\Controllers\ConteudoController@boletins');
Route::get('gercont/noticias','App\Http\Controllers\ConteudoController@noticias');
Route::get('gercont/paginas','App\Http\Controllers\ConteudoController@paginas');
Route::get('gercont/videos','App\Http\Controllers\ConteudoController@videos');
Route::get('gercont/eventos','App\Http\Controllers\ConteudoController@eventos');
Route::get('gercont/oportunidades','App\Http\Controllers\OportunidadeController@lista');
Route::get('gercont/publicacoes','App\Http\Controllers\PublicacaoController@lista');
Route::get('gercont/galeria','App\Http\Controllers\GaleriaController@index');
Route::get('gercont/menus','App\Http\Controllers\ConteudoController@menus');
Route::get('gercont/associados','App\Http\Controllers\AssociadoAdminController@index');

Route::get('associado-admin/create','App\Http\Controllers\AssociadoAdminController@create');
Route::post('associado-admin','App\Http\Controllers\AssociadoAdminController@store');
Route::get('associado-admin/{id}/edit','App\Http\Controllers\AssociadoAdminController@edit');
Route::post('associado-admin/{id}','App\Http\Controllers\AssociadoAdminController@update');
Route::post('associado-admin/{id}/toggle-ativo','App\Http\Controllers\AssociadoAdminController@toggleAtivo');
Route::post('associado-admin/{id}/enviar-acesso','App\Http\Controllers\AssociadoAdminController@enviarAcesso');
Route::post('associado-admin/{id}/destroy','App\Http\Controllers\AssociadoAdminController@destroy');

Route::prefix('associado')->name('associado.')->group(function () {
    Route::get('/','App\Http\Controllers\AssociadoAreaController@index')->name('area');
    Route::get('meus-dados','App\Http\Controllers\AssociadoAreaController@meusDados')->name('dados');
    Route::post('meus-dados','App\Http\Controllers\AssociadoAreaController@atualizarDados')->name('dados.salvar');
    Route::post('alterar-senha','App\Http\Controllers\AssociadoAreaController@alterarSenha')->name('senha.alterar');

    Route::get('entrar','App\Http\Controllers\AssociadoAuthController@loginForm')->name('login');
    Route::post('entrar','App\Http\Controllers\AssociadoAuthController@login')->name('login.entrar')->middleware('throttle:associado-login');
    Route::get('cadastro','App\Http\Controllers\AssociadoAuthController@cadastroForm')->name('cadastro');
    Route::post('cadastro','App\Http\Controllers\AssociadoAuthController@cadastro')->name('cadastro.salvar')->middleware('throttle:associado-cadastro');
    Route::get('recuperar-senha','App\Http\Controllers\AssociadoAuthController@recuperarForm')->name('senha.recuperar');
    Route::post('recuperar-senha','App\Http\Controllers\AssociadoAuthController@recuperar')->name('senha.enviar')->middleware('throttle:associado-senha');
    Route::get('redefinir-senha/{token}','App\Http\Controllers\AssociadoAuthController@redefinirForm')->name('senha.redefinir');
    Route::post('redefinir-senha','App\Http\Controllers\AssociadoAuthController@redefinir')->name('senha.redefinir.salvar')->middleware('throttle:associado-redefinir');
    Route::post('sair','App\Http\Controllers\AssociadoAuthController@logout')->name('logout');
});

Route::get('galeria/json','App\Http\Controllers\GaleriaController@json');
Route::resource('galeria','App\Http\Controllers\GaleriaController')->except(['show', 'index', 'edit', 'update']);

Route::get('/','App\Http\Controllers\HomeController@index')->name('home');

Route::get('boletim/detalhes/{data}','App\Http\Controllers\PaginaController@getBoletim');
Route::get('boletim/download/{id}','App\Http\Controllers\PaginaController@boletim');
Route::get('boletim/publicacao/atualizar/{id}','App\Http\Controllers\BoletimController@atualizar');
Route::post('boletim/novo','App\Http\Controllers\BoletimController@store');
Route::resource('boletim','App\Http\Controllers\BoletimController');

Route::get('evento/ativo/atualizar/{id}','App\Http\Controllers\EventoController@atualizar');
Route::post('evento/novo','App\Http\Controllers\EventoController@store');
Route::resource('evento','App\Http\Controllers\EventoController');

Route::get('publicacao/ativo/atualizar/{id}','App\Http\Controllers\PublicacaoController@atualizar');
Route::resource('publicacao','App\Http\Controllers\PublicacaoController')->except(['show', 'index']);

Route::get('oportunidades/atualizar/{id}','App\Http\Controllers\OportunidadeController@atualizar');
Route::get('oportunidades/show/{id}','App\Http\Controllers\OportunidadeController@show');
Route::get('oportunidades/create','App\Http\Controllers\OportunidadeController@create');
Route::resource('oportunidade','App\Http\Controllers\OportunidadeController')->except(['show', 'create']);


Route::get('contato','App\Http\Controllers\PaginaController@contato');
Route::get('atualizacao-cadastro','App\Http\Controllers\PaginaController@atualizacaoCadastro');

Route::get('noticia/{url}','App\Http\Controllers\NoticiaController@buscar');
Route::get('noticias','App\Http\Controllers\NoticiaController@index');

Route::get('noticia-admin/create','App\Http\Controllers\NoticiaAdminController@create');
Route::post('noticia-admin','App\Http\Controllers\NoticiaAdminController@store');
Route::get('noticia-admin/{id}/edit','App\Http\Controllers\NoticiaAdminController@edit');
Route::post('noticia-admin/{id}','App\Http\Controllers\NoticiaAdminController@update');
Route::post('noticia-admin/{id}/destroy','App\Http\Controllers\NoticiaAdminController@destroy');
Route::get('noticia-admin/{id}/toggle-ativa','App\Http\Controllers\NoticiaAdminController@toggleAtiva');

Route::get('oportunidades','App\Http\Controllers\OportunidadeController@index');

Route::get('pagina/{nome}','App\Http\Controllers\PaginaController@buscar');

Route::get('pagina-admin/create','App\Http\Controllers\PaginaAdminController@create');
Route::post('pagina-admin','App\Http\Controllers\PaginaAdminController@store');
Route::get('pagina-admin/{id}/edit','App\Http\Controllers\PaginaAdminController@edit');
Route::post('pagina-admin/{id}','App\Http\Controllers\PaginaAdminController@update');
Route::get('pagina-admin/{id}/toggle-publicacao','App\Http\Controllers\PaginaAdminController@togglePublicacao');
Route::post('pagina-admin/{id}/documentos','App\Http\Controllers\PaginaAdminController@storeDocumento');
Route::post('pagina-documento/{id}','App\Http\Controllers\PaginaAdminController@updateDocumento');
Route::post('pagina-documento/{id}/destroy','App\Http\Controllers\PaginaAdminController@destroyDocumento');
Route::get('pagina-documento/{id}/toggle','App\Http\Controllers\PaginaAdminController@toggleDocumento');

Route::get('eventos/todos','App\Http\Controllers\EventoController@index');
Route::get('eventos/detalhes/{id}','App\Http\Controllers\EventoController@detalhes');
Route::get('eventos/pesencial/sessao-solene-alesc','App\Http\Controllers\PaginaController@evento');

Route::get('destaque/{nome}','App\Http\Controllers\PaginaController@destaque');

Route::post('email/contato','App\Http\Controllers\EmailController@contato');
Route::post('email/atualizacao-cadastro','App\Http\Controllers\EmailController@atualizacaoCadastro');

Route::get('empresas-publicas/{pagina}','App\Http\Controllers\EmpresaController@publicas');
Route::get('empresas-privadas/{pagina}','App\Http\Controllers\EmpresaController@privadas');

Route::get('videos/todos','App\Http\Controllers\VideoController@index');
Route::get('video/{id}/delete','App\Http\Controllers\VideoController@delete');
Route::get('videos/publicacao/atualizar/{id}','App\Http\Controllers\VideoController@atualizar');
Route::resource('video','App\Http\Controllers\VideoController');