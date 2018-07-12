<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadosBase extends Model
{

    protected $table = 'dadosBase';
    protected $primaryKey = 'idDadosBase';
    protected $fillable = ['nomeBase', 'dadosPessoais', 'idDadosBase', 'secretariaBase', 'localTrabBase'];
    public $rules = ['nomeBase' => 'required',
                     'localTrabBase' => 'required',
                     'secretariaBase' => 'required',
                  ];

    public $messages = ['nomeBase.required' =>  'O Campo NOME é de preenchimento Obrigatório!',
                        'localTrabBase.required' =>  'O Campo LOCAL DE TRABALHO é de preenchimento Obrigatório!',
                        'secretariaBase.required' =>  'O Campo SECRETARIA é de preenchimento Obrigatório!',
                       ];

    public function setNomeBaseAttribute($value){
        $this->attributes['nomeBase'] = mb_strtoupper($value);
    }
    public function setSecretariaBaseAttribute($value){
        $this->attributes['secretariaBase'] = mb_strtoupper($value);
    }
    public function setLocalTrabBaseAttribute($value){
        $this->attributes['localTrabBase'] = mb_strtoupper($value);
    }
    
        
}
