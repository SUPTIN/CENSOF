<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class enderecoContatos extends Model
{
    protected $table = 'enderecoContatos';
    protected $primaryKey = 'idEnderecoContatos';
    protected $fillable = ['idDadosBase', 'cep', 'estadoEC', 'cidadeEC','bairroEC', 'enderecoResidencialEC', 'numeroEC', 'complementoEC', 'telResidencial', 'telCelular', 'email'];
}
