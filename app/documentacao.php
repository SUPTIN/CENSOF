<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class documentacao extends Model
{
    protected $table = 'documentacao';
    protected $primaryKey = 'idDocumentacao';
    protected $fillable = ['idDadosBase', 'cpf', 'rg', 'orgaoEmissorRG', 'ufRG', 'dataEmissaoRG', 'ctps', 'serie', 'ufCtps', 'dataEmissaoCtps', 'pisPasep', 'dataCadPisPasep', 'tituloEleitor', 'zona', 'secao', 'dataEmissaoTituloEleitor', 'ufVotacao', 'cidadeVotacao', 'certMilitar', 'certMilitarSituacao', 'dataCertMilitar', 'tipoCertMilitar', 'ufCertMilitar', 'numCNH', 'registroCNH', 'categoriaCNH', 'dataEmissaoCNH', 'dataValidadeCNH', 'ufCNH', 'primeiraHabilitacao', 'conselhoProfissional', 'numConselhoProf', 'dataEmissaoConselhoProf', 'dataValidadeConselhoProf'];
    public $rules = ['cpf' => 'required',
                     'rg' => 'required',
                     'orgaoEmissorRG' => 'required',
                     'ufRG' => 'required',
                     'dataEmissaoRG' => 'required',
                     'ctps' => 'required',
                     'serie' => 'required',
                     'ufCtps' => 'required',
                     'dataEmissaoCtps' => 'required',
                     'pisPasep' => 'required',
                     'dataCadPisPasep' => 'required',
                     'tituloEleitor' => 'required',
                     'zona' => 'required',
                     'secao' => 'required',
                     'dataEmissaoTituloEleitor' => 'required',
                     'ufVotacao' => 'required',
                     'cidadeVotacao' => 'required',
                  ];

    public $messages = ['cpf.required' =>  'O Campo CPF é de preenchimento Obrigatório!',
                        'rg.required' =>  'O Campo RG é de preenchimento Obrigatório!',
                        'orgaoEmissorRG.required' =>  'O Campo ORGÃO EMISSOR é de preenchimento Obrigatório!',
                        'ufRG.required' =>  'O Campo UF para RG é de preenchimento Obrigatório!',
                        'dataEmissaoRG.required' =>  'O Campo DATA EMISSÃO para RG é de preenchimento Obrigatório!',
                        'ctps.required' =>  'O Campo NÚMERO CTPS é de preenchimento Obrigatório!',
                        'serie.required' =>  'O Campo SERIEpara CTPS é de preenchimento Obrigatório!',
                        'ufCtps.required' =>  'O Campo UF para CTPS é de preenchimento Obrigatório!',
                        'dataEmissaoCtps.required' =>  'O Campo DATA EMISSÃO para CTPS é de preenchimento Obrigatório!',
                        'pisPasep.required' =>  'O Campo PIS/PASEP é de preenchimento Obrigatório!',
                        'dataCadPisPasep.required' =>  'O Campo DATA DE CADASTRAMENTO é de preenchimento Obrigatório!',
                        'tituloEleitor.required' =>  'O Campo TÍTULO DE ELEITOR é de preenchimento Obrigatório!',
                        'zona.required' =>  'O Campo ZONA é de preenchimento Obrigatório!',
                        'secao.required' =>  'O Campo SEÇÃO é de preenchimento Obrigatório!',
                        'dataEmissaoTituloEleitor.required' =>  'O Campo DATA EMISSÃO para Título de Eleitor é de preenchimento Obrigatório!',
                        'cidadeVotacao.required' =>  'O Campo CIDADE DE VOTAÇÃO é de preenchimento Obrigatório!',
                        'ufVotacao.required' =>  'O Campo UF DE VOTAÇÃO é de preenchimento Obrigatório!',
                       ];
}
