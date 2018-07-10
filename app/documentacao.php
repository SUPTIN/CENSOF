<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class documentacao extends Model
{
    protected $table = 'documentacao';
    protected $primaryKey = 'idDocumentacao';
    protected $fillable = ['idDadosBase', 'cpf', 'rg', 'orgaoEmissorRG', 'ufRg', 'dataEmissaoRg', 'ctps', 'serie', 'ufCtps', 'dataEmissaoCtps', 'pisPasep', 'dataCadPisPasep', 'tituloEleitor', 'zona', 'secao', 'dataEmissaoTituloEleitor', 'ufVotacao', 'cidadeVotacao', 'certMilitar', 'certMilitarSituacao', 'dataCertMilitar', 'tipoCertMilitar', 'ufCertMilitar', 'numCNH', 'registroCNH', 'categoriaCNH', 'dataEmissaoCNH', 'dataValidadeCNH', 'ufCNH', 'primeiraHabilitacao', 'conselhoProfissional', 'numConselhoProf', 'dataEmissaoConselhoProf', 'dataValidadeConselhoProf'];
}
