<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dependente extends Model
{
    protected $table = 'dependentes';
    protected $primaryKey = 'idDependente';
    protected $fillable = ['idDadosBase', 'nomeDependente', 'dataNascDependente', 'sexoDependente', 'parentesco', 'cpfDependente', 'estadoCivilDependente', 'deducaoImposto', 'salarioFamilia'];
    public $rules = ['nomeDependente' => 'required',
                     'dataNascDependente' => 'required',
                     'sexoDependente' => 'required',
                     'parentesco' => 'required',
                     'cpfDependente' => 'required',
                     'estadoCivilDependente' => 'required',
                     'deducaoImposto' => 'required',
                     'salarioFamilia' => 'required',
                  ];

    public $messages = ['nomeDependente.required' =>  'O Campo NOME é de preenchimento Obrigatório!',
                        'dataNascDependente.required' =>  'O Campo DATA DE NASCIMENTO é de preenchimento Obrigatório!',
                        'sexoDependente.required' =>  'O Campo SEXO é de preenchimento Obrigatório!',
                        'parentesco.required' =>  'O Campo GRAU de PARENTESCO é de preenchimento Obrigatório!',
                        'cpfDependente.required' =>  'O Campo CPF é de preenchimento Obrigatório!',
                        'estadoCivilDependente.required' =>  'O Campo ESTADO CiVIL é de preenchimento Obrigatório!',
                        'deducaoImposto.required' =>  'O Campo DEPENDENTE PARA FINS DE DEDUÇÃO DE IMPOSTO DE RENDA é de preenchimento Obrigatório!',
                        'salarioFamilia.required' =>  'O Campo DEPENDENTE PARA FINS DE RECEBIMENTO DE SALÁRIO FAMILIA é de preenchimento Obrigatório!',
                       ];
}
