<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class arquivos extends Model
{
    protected $table = 'arquivos';
    protected $primaryKey = 'idArquivo';
    protected $fillable = ['idDadosBase', 'tipoDocumento', 'arquivoDoc'];
    public $rules = ['tipoDocumento' => 'required',
                     'arquivoDoc' => 'required',];

    public $messages = ['arquivoDoc.required' => 'O campo DOCUMENTO é de preenchimento obrigatório!',
                        'tipoDocumento.required' => 'O campo TIPO DOC. é de preenchimento obrigatório!',
                       ];

}
