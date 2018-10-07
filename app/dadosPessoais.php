<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadosPessoais extends Model
{
    protected $table = 'dadosPessoais';
    protected $primaryKey = 'idDadosPessoais';
    protected $fillable = ['idDadosBase', 'dataNasc', 'sexo', 'paisNasc', 'estadoNasc', 'cidadeNasc', 'nomeMae', 'nomePai', 'estadoCivil', 'dataCasamento', 'nomeConjugue', 'racaCor', 'tipoSanguinio', 'escolaridade', 'areaInstrucao', 'estrangeiro', 'dataChegadaBrasil', 'naturalizado', 'dataNaturalizado', 'possuiDeficiencia', 'qualDeficiencia'];

    public $rules = ['dataNasc' => 'required',
                     'sexo' => 'required',
                     'paisNasc' => 'required',
                     'estadoNasc' => 'required',
                     'cidadeNasc' => 'required',
                     'nomeMae' => 'required',
                     'estadoCivil' => 'required',
                     'escolaridade' => 'required',
                     'tipoSanguinio' => 'required',
                     'racaCor' => 'required',
                     'estrangeiro' => 'required',
                     'naturalizado' => 'required',
                     'possuiDeficiencia' => 'required',
                  ];

    public $messages = ['dataNasc.required' =>  'O Campo DATA DE NASCIMENTO é de preenchimento Obrigatório, com formato dd/mm/yyyy!',
                        'sexo.required' =>  'O Campo SEXO é de preenchimento Obrigatório!',
                        'paisNasc.required' =>  'O Campo PAÍS DE NASCIMENTO é de preenchimento Obrigatório!',
                        'estadoNasc.required' =>  'O Campo ESTADO DE NASCIMENTO é de preenchimento Obrigatório!',
                        'cidadeNasc.required' =>  'O Campo CIDADE DE NASCIMENTO é de preenchimento Obrigatório!',
                        'nomeMae.required' =>  'O Campo NOME DE MÃE é de preenchimento Obrigatório!',
                        'estadoCivil.required' =>  'O Campo ESTADO CIVIL é de preenchimento Obrigatório!',
                        'escolaridade.required' =>  'O Campo ESCOLARIDADE é de preenchimento Obrigatório!',
                        'tipoSanguinio.required' =>  'O Campo TIPO SANGUINIO  é de preenchimento Obrigatório!',
                        'racaCor.required' =>  'O Campo RAÇA/COR é de preenchimento Obrigatório!',
                        'estrangeiro.required' =>  'O Campo ESTRANGEIRO é de preenchimento Obrigatório!',
                        'naturalizado.required' =>  'O Campo NATURALIZADO é de preenchimento Obrigatório!',
                        'possuiDeficiencia.required' =>  'O Campo POSSUI ALGUM TIPO DE DEFICIÊNCIA é de preenchimento Obrigatório!',
                       ];
    public function setNomeMaeAttribute($value){
        $this->attributes['nomeMae'] = mb_strtoupper($value);
    }
    public function setNomePaiAttribute($value){
        $this->attributes['nomePai'] = mb_strtoupper($value);
    }
    public function setNomeConjugueAttribute($value){
        $this->attributes['nomeConjugue'] = mb_strtoupper($value);
    }
    public function setAreaInstrucaoAttribute($value){
        $this->attributes['areaInstrucao'] = mb_strtoupper($value);
    }
    public function setQualDeficienciaAttribute($value){
        $this->attributes['qualDeficiencia'] = mb_strtoupper($value);
    }

}
