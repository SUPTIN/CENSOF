<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pais extends Model
{
    protected $table = 'pais';

    protected $fillable = ['paisNome', 'paisName'];

    public $rules = ['paisNome' => 'required|min:5|max:50',];

    public $messages = ['descricao.required' => 'O campo NOME PAIS é de preenchimento obrigatório!',
                        'descricao.min' => 'O campo NOME PAIS deve conter 5 caracteres no mínimo.',
                        'descricao.max' => 'O campo NOME PAIS deve conter 50 caracteres no máximo.',];
}
