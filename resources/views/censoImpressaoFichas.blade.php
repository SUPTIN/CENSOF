@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Confirmação dos dados</h4>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <a href="impressaoFichasPDF"> 
                             Download PDF <i class="fa fa-print" aria-hidden="true" title="Imprimir Ficha"> </i>
                          </a>
                        </div>
                      </div> 

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Dados Funcionais</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-9">
                          <b>Nome:</b> {{$dadosBase[0]->nomeBase}}
                        </div>
                      </div>
                     <div class="row">
                        <div class="col-sm-6">
                          <b>Matricula:</b> {{$dadosBase[0]->matriculaBase}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Data de Admissão:</b> {{$dadosBase[0]->admissaoBase}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Cargo:</b> {{$dadosBase[0]->cargoBase}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Local de Trabalho:</b> {{$dadosBase[0]->localTrabBase}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Secretaria de Lotação:</b> {{$dadosBase[0]->secretariaBase}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Dados Pessoais</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Data de Nascimento: {{$dadosPessoais[0]->dataNasc}}
                        </div>  
                        <div class="col-sm-6">
                          Sexo: {{$dadosPessoais[0]->sexo}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          País de Nascimento: {{$dadosPessoais[0]->paisNasc}}
                        </div>  
                        <div class="col-sm-4">
                          Estado: {{$dadosPessoais[0]->estadoNasc}}
                        </div>  
                        <div class="col-sm-4">
                          Cidade de Nascimento: {{$dadosPessoais[0]->cidadeNasc}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          Nome de Mãe: {{$dadosPessoais[0]->nomeMae}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Nome de Pai: {{$dadosPessoais[0]->nomePai}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Estado Cívil: {{$dadosPessoais[0]->estadoCivil}}
                        </div>  
                        <div class="col-sm-6">
                          Data do Casamento: {{$dadosPessoais[0]->dataCasamento}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Nome Conjugue: {{$dadosPessoais[0]->nomeConjugue}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Raça/Cor: {{$dadosPessoais[0]->racaCor}}
                        </div>  
                        <div class="col-sm-6">
                          Tipo Sanguínio: {{$dadosPessoais[0]->tipoSanguinio}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Escolaridade: {{$dadosPessoais[0]->escolaridade}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Área de Instrução: {{$dadosPessoais[0]->areaInstrucao}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Estrangeiro: {{$dadosPessoais[0]->estrangeiro}}
                        </div>  
                        <div class="col-sm-6">
                          Data de Chegada ao Brasil: {{$dadosPessoais[0]->dataChegadaBrasil}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Naturalizado: {{$dadosPessoais[0]->naturalizado}}
                        </div>  
                        <div class="col-sm-6">
                          Data da Naturalização: {{$dadosPessoais[0]->dataNaturalizado}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Possui algum tipo de deficiência: {{$dadosPessoais[0]->possuiDeficiencia}}
                        </div>  
                        <div class="col-sm-6">
                          Qual?: {{$dadosPessoais[0]->qualDeficiencia}}
                        </div>  
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Endereço e Contatos</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-8">
                          Endereço Residêncial: {{$dadosEndContato[0]->enderecoResidencialEC}}
                        </div>  
                        <div class="col-sm-2">
                          Número: {{$dadosEndContato[0]->numeroEC}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Complemento: {{$dadosEndContato[0]->complementoEC}}
                        </div>  
                        <div class="col-sm-6">
                          Bairro: {{$dadosEndContato[0]->bairroEC}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Cidade: {{$dadosEndContato[0]->cidadeEC}}
                        </div>    
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Estado: {{$dadosEndContato[0]->estadoEC}}
                        </div>  
                        <div class="col-sm-6">
                          CEP: {{$dadosEndContato[0]->cep}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Telefone Residencial: {{$dadosEndContato[0]->telResidencial}}
                        </div>  
                        <div class="col-sm-6">
                          Telefone Celular: {{$dadosEndContato[0]->telCelular}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          E-mail: {{$dadosEndContato[0]->email}}
                        </div>  
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Documentação</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          CPF: {{$dadosDocumentacao[0]->cpf}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          RG: {{$dadosDocumentacao[0]->rg}}
                        </div>  
                        <div class="col-sm-3">
                          Orgão Emissor: {{$dadosDocumentacao[0]->orgaoEmissorRG}}
                        </div> 
                        <div class="col-sm-3">
                          UF: {{$dadosDocumentacao[0]->ufRG}}
                        </div> 
                        <div class="col-sm-3">
                          Data de Emissão: {{$dadosDocumentacao[0]->dataEmissaoRG}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          Nº CTPS: {{$dadosDocumentacao[0]->ctps}}
                        </div>  
                        <div class="col-sm-3">
                          Série: {{$dadosDocumentacao[0]->serie}}
                        </div> 
                        <div class="col-sm-3">
                          UF: {{$dadosDocumentacao[0]->ufCtps}}
                        </div> 
                        <div class="col-sm-3">
                          Data de Emissão: {{$dadosDocumentacao[0]->dataEmissaoCtps}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          PIS/PASEP: {{$dadosDocumentacao[0]->pisPasep}}
                        </div>  
                        <div class="col-sm-3">
                          Data de Cadastramento: {{$dadosDocumentacao[0]->dataCadPisPasep}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          Título de Eleitor: {{$dadosDocumentacao[0]->tituloEleitor}}
                        </div>  
                        <div class="col-sm-3">
                          Zona: {{$dadosDocumentacao[0]->zona}}
                        </div> 
                        <div class="col-sm-3">
                          Seção: {{$dadosDocumentacao[0]->secao}}
                        </div> 
                        <div class="col-sm-3">
                          Data de Emissão: {{$dadosDocumentacao[0]->dataEmissaoTituloEleitor}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Cidade de Votação: {{$dadosDocumentacao[0]->cidadeVotacao}}
                        </div>  
                        <div class="col-sm-6">
                          UF de Votação: {{$dadosDocumentacao[0]->ufVotacao}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          Certificado Militar: {{$dadosDocumentacao[0]->certMilitar}}
                        </div>  
                        <div class="col-sm-4">
                          Situação: {{$dadosDocumentacao[0]->certMilitarSituacao}}
                        </div> 
                        <div class="col-sm-4">
                          Data de Emissão: {{$dadosDocumentacao[0]->dataCertMilitar}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Tipo: {{$dadosDocumentacao[0]->tipoCertMilitar}}
                        </div>  
                        <div class="col-sm-6">
                          UF: {{$dadosDocumentacao[0]->ufCertMilitar}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          CNH Nº: {{$dadosDocumentacao[0]->numCNH}}
                        </div>  
                        <div class="col-sm-3">
                          Registro: {{$dadosDocumentacao[0]->registroCNH}}
                        </div> 
                        <div class="col-sm-3">
                          Categoria: {{$dadosDocumentacao[0]->categoriaCNH}}
                        </div>
                        <div class="col-sm-3">
                          Data de Emissão: {{$dadosDocumentacao[0]->dataEmissaoCNH}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          UF: {{$dadosDocumentacao[0]->ufCNH}}
                        </div>  
                        <div class="col-sm-4">
                          Data de Validade: {{$dadosDocumentacao[0]->dataValidadeCNH}}
                        </div> 
                        <div class="col-sm-4">
                          Primeira Habilitação: {{$dadosDocumentacao[0]->primeiraHabilitacao}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Nome do Conselho Profissional: {{$dadosDocumentacao[0]->conselhoProfissional}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          Nº Registro: {{$dadosDocumentacao[0]->numConselhoProf}}

                        </div>  
                        <div class="col-sm-4">
                          Data de Emissão: {{$dadosDocumentacao[0]->dataEmissaoConselhoProf}}
                        </div> 
                        <div class="col-sm-4">
                          Data de Validade: {{$dadosDocumentacao[0]->dataValidadeConselhoProf}}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Dependentes</b></h5>
                        </div>
                      </div>
                      @forelse($dadosDependente as $dependente)
                        <div class="row">
                          <div class="col-sm-12">
                            Nome: {{$dependente->nomeDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            Data de Nascimento: {{$dependente->dataNascDependente}}
                          </div>
                          <div class="col-sm-6">
                            Sexo: {{$dependente->sexoDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            Grau de Parentesco: {{$dependente->parentesco}}
                          </div>
                          <div class="col-sm-6">
                            cpfDependente: {{$dependente->cpfDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            Estado Cívil: {{$dependente->estadoCivilDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            Dependente para fins de Dedução de Imposto de Renda? {{$dependente->deducaoImposto}}
                          </div>
                          <div class="col-sm-6">
                            Dependente para fins de Recebimento de Salário Família? {{$dependente->salarioFamilia}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <br/>
                          </div>
                        </div>

                      @empty
                        <div class="row">
                          <div class="col-sm-12">
                             <p> Não existe Dependente cadastrado!</p>
                          </div>
                        </div>
                      @endforelse
                </div>
            </div>
      </div>
   </div>
</div>
@endsection

