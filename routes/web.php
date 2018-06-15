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

Route::get('dadosPessoais', 'censoController@dadosPessoais');
Route::get('enderecoContatos', 'censoController@enderecoContatos');
Route::get('documentacao', 'censoController@documentacao');
Route::get('dependentes', 'censoController@dependentes');
Route::get('novoDependente', 'censoController@novoDependente');
Route::get('getCidades', 'censoController@getCidades');

Route::get('/', 'censoController@dadosBase');

/*Route::get('/', function () {
    return view('welcome');
}); */
