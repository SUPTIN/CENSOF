<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class escolaridade extends Model
{
    protected $table = 'escolaridade';

    protected $fillable = ['descricaoEscolaridade'];

    public $rules = ['descricaoEscolaridade' => 'required|min:5|max:255',];

    public $messages = ['descricao.required' => 'O campo DESCRIÇÃO ESCOLARIDADE é de preenchimento obrigatório!',
                        'descricao.min' => 'O campo DESCRIÇÃO ESCOLARIDADE deve conter 5 caracteres no mínimo.',
                        'descricao.max' => 'O campo DESCRIÇÃO ESCOLARIDADE deve conter 255 caracteres no máximo.',];
}
