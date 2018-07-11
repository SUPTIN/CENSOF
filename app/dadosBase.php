<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadosBase extends Model
{
    protected $table = 'dadosBase';
    protected $primaryKey = 'idDadosBase';
    protected $fillable = ['nomeBase', 'dadosPessoais', 'idDadosBase'];
    public $rules = ['nomeBase' => 'required',
                  ];

    public $messages = ['nomeBase.required' =>  'O Campo NOME é de preenchimento Obrigatório!',
                       ];
}
