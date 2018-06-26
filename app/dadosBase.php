<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadosBase extends Model
{
    protected $table = 'dadosBase';
    protected $primaryKey = 'idDadosBase';
    protected $fillable = ['nomeBase', 'dadosPessoais', 'idDadosBase'];



}
