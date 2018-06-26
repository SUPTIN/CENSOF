<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadosPessoais extends Model
{
    protected $table = 'dadosPessoais';
    protected $primaryKey = 'idDadosPessoais';
    protected $fillable = ['idDadosBase', 'dataNasc', 'sexo', 'paisNasc', 'estadoNasc', 'cidadeNasc', 'nomeMae', 'nomePai', 'estadoCivil', 'dataCasamento', 'nomeConjugue', 'racaCor', 'tipoSanguinio', 'escolaridade', 'areaInstrucao', 'estrangeiro', 'dataChegadaBrasil', 'naturalizado', 'dataNaturalizado', 'possuiDeficiencia', 'qualDeficiencia'];
}
