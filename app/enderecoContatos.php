<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enderecoContatos extends Model
{
    protected $table = 'enderecoContatos';
    protected $primaryKey = 'idEnderecoContatos';
    protected $fillable = ['idDadosBase', 'cep', 'estadoEC', 'cidadeEC','bairroEC', 'enderecoResidencialEC', 'numeroEC', 'complementoEC', 'telResidencial', 'telCelular', 'email'];
    public $rules = ['cep' => 'required',
                     'estadoEC' => 'required',
                     'cidadeEC' => 'required',
                     'bairroEC' => 'required',
                     'enderecoResidencialEC' => 'required',
                     'numeroEC' => 'required',
                     'telCelular' => 'required',
                  ];

    public $messages = ['cep.required' =>  'O Campo CEP é de preenchimento Obrigatório!',
                        'estadoEC.required' =>  'O Campo ESTADP é de preenchimento Obrigatório!',
                        'cidadeEC.required' =>  'O Campo CIDADE é de preenchimento Obrigatório!',
                        'bairroEC.required' =>  'O Campo BAIRRO é de preenchimento Obrigatório!',
                        'enderecoResidencialEC.required' =>  'O Campo ENDEREÇO RESIDENCIAL é de preenchimento Obrigatório!',
                        'numeroEC.required' =>  'O Campo NUMERO é de preenchimento Obrigatório!',
                        'telCelular.required' =>  'O Campo TEL. CELULAR é de preenchimento Obrigatório!',
                       ];
}
