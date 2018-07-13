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

Route::get('{id}/dependentes', 'censoController@dependentes');
Route::get('{id}/novoDependente', 'censoController@novoDependente');
Route::get('{id}/editDependente', 'censoController@editDependente');
Route::post('{id}/editDep', 'censoController@updateDep');
Route::post('{id}/dep', 'censoController@insereDependente');
Route::get('{id}/delDependente', 'censoController@delDependente');

Route::get('getCidades', 'censoController@getCidades');

Route::get('{id}/impressaoFichas', 'censoController@impressaoCensoF');
Route::get('{id}/impressaoFichasPDF', 'censoController@impressaoPDF');

Route::get('{id}/anexaArquivos', 'censoController@anexarArquivos');


Route::get('/', 'censoController@dadosBase');

/*Route::get('/', function () {
    return view('welcome');
}); */
