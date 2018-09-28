<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadosBase extends Model
{

    protected $table = 'dadosBase';
    protected $primaryKey = 'idDadosBase';
    protected $fillable = ['nomeBase', 'idDadosBase', 'secretariaBase', 'localTrabBase', 'cargaHorariaBase', 'horarioTrabBase'];
    public $rules = ['nomeBase' => 'required',
                     'localTrabBase' => 'required',
                     'secretariaBase' => 'required',
                     'cargaHorariaBase' => 'required',
                     'horarioTrabBase' => 'required',
                  ];

    public $messages = ['nomeBase.required' =>  'O Campo NOME é de preenchimento Obrigatório!',
                        'localTrabBase.required' =>  'O Campo LOCAL DE TRABALHO é de preenchimento Obrigatório!',
                        'secretariaBase.required' =>  'O Campo SECRETARIA é de preenchimento Obrigatório!',
                        'cargaHorariaBase.required' =>  'O Campo CARGA HORÁRIA é de preenchimento Obrigatório!',
                        'horarioTrabBase.required' =>  'O Campo HORÁRIO E DIAS TRABALHADOS é de preenchimento Obrigatório!',
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
    public function setCargaHorariaBaseAttribute($value){
        $this->attributes['cargaHorariaBase'] = mb_strtoupper($value);
    }
    public function setHorarioTrabBaseAttribute($value){
        $this->attributes['horarioTrabBase'] = mb_strtoupper($value);
    }
        
}
