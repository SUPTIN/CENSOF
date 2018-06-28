<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dependente extends Model
{
    protected $table = 'dependentes';
    protected $primaryKey = 'idDependente';
    protected $fillable = ['idDadosBase', 'nomeDependente', 'dataNascDependente', 'sexoDependente', 'parentesco', 'cpfDependente', 'estadoCivilDependente', 'deducaoImposto', 'salarioFamilia'];
}
