<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vinculoEmpregaticio extends Model
{

    protected $table = 'vincEmpregaticio';
    protected $primaryKey = 'idVincEmpregaticio';
    protected $fillable = ['idDadosBase', 'vinculoEmpregaticio', 'qualVinculo', 'orgaoEmpregaticio', 'cargoVinculo', 'cargaHorariaVinculo', 'turnoVinculo', 'horarioDiasTrabVinculo', 'funcaoGratificada', 'cargoGratificado',];
    public $rules = ['vinculoEmpregaticio' => 'required',
                     'funcaoGratificada' => 'required',
                  ];

    public $messages = ['vinculoEmpregaticio.required' =>  'O Campo POSSUI VÍNCULO EMPREGATÍCIO EM OUTRO ÓRGÃO é de preenchimento Obrigatório!',
                        'funcaoGratificada.required' =>  'O Campo POSSUI CARGO OU FUNÇÃO GRATIFICADA é de preenchimento Obrigatório!',
                       ];

    public function setOrgaoEmpregaticioAttribute($value){
        $this->attributes['orgaoEmpregaticio'] = mb_strtoupper($value);
    }
        
}
