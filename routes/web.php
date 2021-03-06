<?php

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

Route::get('informacao', 'Controller@informacao');

Route::get('{id}/dadosPessoais', 'censoController@dadosPessoais');
Route::post('{id}/iDP', 'censoController@insereDadosPessoais');

Route::get('{id}/enderecoContatos', 'censoController@enderecoContatos');
Route::post('{id}/eC', 'censoController@insereEnderecoContatos');

Route::get('{id}/documentacao', 'censoController@documentacao');
Route::post('{id}/doc', 'censoController@insereDocumentacao');

Route::get('{id}/vincEmpregaticio', 'censoController@vincEmpreg');
Route::post('{id}/iVinculo', 'censoController@insereVincEmpreg');

Route::get('{id}/dependentes', 'censoController@dependentes');
Route::get('{id}/novoDependente', 'censoController@novoDependente');
Route::get('{id}/editDependente', 'censoController@editDependente');
Route::post('{id}/editDep', 'censoController@updateDep');
Route::post('{id}/dep', 'censoController@insereDependente');
Route::get('{id}/delDependente', 'censoController@delDependente');
Route::get('{id}/dependenteRegras', 'censoController@dependenteRegras');

Route::get('getCidades', 'censoController@getCidades');

Route::get('{id}/impressaoFichas', 'censoController@impressaoCensoF');
Route::get('{id}/impressaoFichasPDF', 'censoController@impressaoPDF');

Route::get('{id}/anexaArquivos', 'censoController@anexarArquivos');
Route::get('{id}/novoDocumento', 'censoController@novoUpDocumento');
Route::post('{id}/insereArq', 'censoController@insereArquivo');
Route::get('{id}/viewArquivo', 'censoController@viewArquivo');
Route::get('{id}/delArquivo', 'censoController@delArquivo');
Route::get('{id}/arquivosRegras', 'censoController@arquivosRegras');

Route::get('semPermissao', 'censoController@semPermissao');

Route::get('dados', 'censoController@dadosBase');

/*Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();
Route::get('/', 'censoController@dadosBase')->name('/');
Route::get('/trocaSenha', 'censoController@viewTrocaSenha');
Route::post('/updateSenha', 'censoController@updateTrocaSenha');
