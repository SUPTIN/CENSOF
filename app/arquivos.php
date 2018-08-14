<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class arquivos extends Model
{
    protected $table = 'arquivos';
    protected $primaryKey = 'idArquivo';
    protected $fillable = ['idDadosBase', 'tipoDocumento', 'arquivoDoc'];

}
