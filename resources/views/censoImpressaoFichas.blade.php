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
                        <div class="col-sm-6">
                          <b>Carga Horária:</b> {{$dadosBase[0]->cargaHorariaBase}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Horário/dias Trabalhados:</b> {{$dadosBase[0]->horarioTrabBase}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Dados Pessoais</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Data de Nascimento: </b>{{$dadosPessoais[0]->dataNasc}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Sexo: </b>{{$dadosPessoais[0]->sexo}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <b>País de Nascimento: </b>{{$dadosPessoais[0]->paisNasc}}
                        </div>  
                        <div class="col-sm-4">
                          <b>Estado:</b> {{$dadosPessoais[0]->estadoNasc}}
                        </div>  
                        <div class="col-sm-4">
                          <b>Cidade de Nascimento: </b> {{$dadosPessoais[0]->cidadeNasc}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <b>Nome de Mãe: </b>{{$dadosPessoais[0]->nomeMae}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <b>Nome de Pai: </b>{{$dadosPessoais[0]->nomePai}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Estado Cívil:</b> {{$dadosPessoais[0]->estadoCivil}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Data do Casamento:</b> {{$dadosPessoais[0]->dataCasamento}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <b>Nome Conjugue:</b> {{$dadosPessoais[0]->nomeConjugue}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Raça/Cor: </b>{{$dadosPessoais[0]->racaCor}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Tipo Sanguínio:</b> {{$dadosPessoais[0]->tipoSanguinio}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <b>Escolaridade:</b> {{$dadosPessoais[0]->escolaridade}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <b>Área de Instrução:</b> {{$dadosPessoais[0]->areaInstrucao}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Estrangeiro: </b>{{$dadosPessoais[0]->estrangeiro}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Data de Chegada ao Brasil: </b>{{$dadosPessoais[0]->dataChegadaBrasil}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Naturalizado: </b>{{$dadosPessoais[0]->naturalizado}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Data da Naturalização: </b>{{$dadosPessoais[0]->dataNaturalizado}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Possui algum tipo de deficiência: </b>{{$dadosPessoais[0]->possuiDeficiencia}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Qual?: </b>{{$dadosPessoais[0]->qualDeficiencia}}
                        </div>  
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Endereço e Contatos</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-8">
                          <b>Endereço Residêncial: </b>{{$dadosEndContato[0]->enderecoResidencialEC}}
                        </div>  
                        <div class="col-sm-2">
                          <b>Número: </b>{{$dadosEndContato[0]->numeroEC}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Complemento: </b>{{$dadosEndContato[0]->complementoEC}}
                        </div>  
                        <div class="col-sm-6">
                          <b>Bairro: </b>{{$dadosEndContato[0]->bairroEC}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <b>Cidade: </b>{{$dadosEndContato[0]->cidadeEC}}
                        </div>    
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Estado: </b>{{$dadosEndContato[0]->estadoEC}}
                        </div>  
                        <div class="col-sm-6">
                          <b>CEP: </b>{{$dadosEndContato[0]->cep}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Telefone Residencial: </b>{{$dadosEndContato[0]->telResidencial}}
                        </div>  
                        <div class="col-sm-6">
                         <b>Telefone Celular: </b>{{$dadosEndContato[0]->telCelular}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>E-mail: </b>{{$dadosEndContato[0]->email}}
                        </div>  
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Documentação</b></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <b>CPF: </b>{{$dadosDocumentacao[0]->cpf}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <b>RG: </b>{{$dadosDocumentacao[0]->rg}}
                        </div>  
                        <div class="col-sm-3">
                          <b>Orgão Emissor: </b>{{$dadosDocumentacao[0]->orgaoEmissorRG}}
                        </div> 
                        <div class="col-sm-3">
                          <b>UF: </b>{{$dadosDocumentacao[0]->ufRG}}
                        </div> 
                        <div class="col-sm-3">
                          <b>Data de Emissão: </b>{{$dadosDocumentacao[0]->dataEmissaoRG}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <b>Nº CTPS: </b>{{$dadosDocumentacao[0]->ctps}}
                        </div>  
                        <div class="col-sm-3">
                          <b>Série: </b>{{$dadosDocumentacao[0]->serie}}
                        </div> 
                        <div class="col-sm-3">
                          <b>UF: </b>{{$dadosDocumentacao[0]->ufCtps}}
                        </div> 
                        <div class="col-sm-3">
                          <b>Data de Emissão: </b>{{$dadosDocumentacao[0]->dataEmissaoCtps}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <b>PIS/PASEP: </b>{{$dadosDocumentacao[0]->pisPasep}}
                        </div>  
                        <div class="col-sm-3">
                          <b>Data de Cadastramento: </b>{{$dadosDocumentacao[0]->dataCadPisPasep}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <b>Título de Eleitor: </b>{{$dadosDocumentacao[0]->tituloEleitor}}
                        </div>  
                        <div class="col-sm-3">
                          <b>Zona: </b>{{$dadosDocumentacao[0]->zona}}
                        </div> 
                        <div class="col-sm-3">
                          <b>Seção: </b>{{$dadosDocumentacao[0]->secao}}
                        </div> 
                        <div class="col-sm-3">
                          <b>Data de Emissão: </b>{{$dadosDocumentacao[0]->dataEmissaoTituloEleitor}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Cidade de Votação: </b>{{$dadosDocumentacao[0]->cidadeVotacao}}
                        </div>  
                        <div class="col-sm-6">
                          <b>UF de Votação: </b>{{$dadosDocumentacao[0]->ufVotacao}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <b>Certificado Militar: </b>{{$dadosDocumentacao[0]->certMilitar}}
                        </div>  
                        <div class="col-sm-4">
                          <b>Situação: </b>{{$dadosDocumentacao[0]->certMilitarSituacao}}
                        </div> 
                        <div class="col-sm-4">
                          <b>Data de Emissão: </b>{{$dadosDocumentacao[0]->dataCertMilitar}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <b>Tipo: </b>{{$dadosDocumentacao[0]->tipoCertMilitar}}
                        </div>  
                        <div class="col-sm-6">
                          <b>UF: </b>{{$dadosDocumentacao[0]->ufCertMilitar}}
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <b>CNH Nº: </b>{{$dadosDocumentacao[0]->numCNH}}
                        </div>  
                        <div class="col-sm-3">
                          <b>Registro: </b>{{$dadosDocumentacao[0]->registroCNH}}
                        </div> 
                        <div class="col-sm-3">
                          <b>Categoria: </b>{{$dadosDocumentacao[0]->categoriaCNH}}
                        </div>
                        <div class="col-sm-3">
                          <b>Data de Emissão: </b>{{$dadosDocumentacao[0]->dataEmissaoCNH}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <b>UF: </b>{{$dadosDocumentacao[0]->ufCNH}}
                        </div>  
                        <div class="col-sm-4">
                          <b>Data de Validade: </b>{{$dadosDocumentacao[0]->dataValidadeCNH}}
                        </div> 
                        <div class="col-sm-4">
                          <b>Primeira Habilitação: </b>{{$dadosDocumentacao[0]->primeiraHabilitacao}}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-8">
                          <b>Nome do Conselho Profissional: </b>{{$dadosDocumentacao[0]->conselhoProfissional}}
                        </div>  
                        <div class="col-sm-4">
                          <b>Orgão Emissor: </b>{{$dadosDocumentacao[0]->orgaoEmissorConselhoProf}}
                        </div>  
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <b>Nº Registro: </b>{{$dadosDocumentacao[0]->numConselhoProf}}

                        </div>  
                        <div class="col-sm-4">
                          <b>Data de Emissão: </b>{{$dadosDocumentacao[0]->dataEmissaoConselhoProf}}
                        </div> 
                        <div class="col-sm-4">
                          <b>Data de Validade: </b>{{$dadosDocumentacao[0]->dataValidadeConselhoProf}}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <h5><b>Total de arquivos anexados: {{$tArquivos}}</b></h5>
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
                            <b>Nome: </b>{{$dependente->nomeDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <b>Data de Nascimento: </b>{{$dependente->dataNascDependente}}
                          </div>
                          <div class="col-sm-6">
                            <b>Sexo: </b>{{$dependente->sexoDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <b>Grau de Parentesco: </b>{{$dependente->parentesco}}
                          </div>
                          <div class="col-sm-6">
                            <b>CPF Dependente: </b>{{$dependente->cpfDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <b>Estado Cívil: </b>{{$dependente->estadoCivilDependente}}
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <b>Dependente para fins de Dedução de Imposto de Renda? </b>{{$dependente->deducaoImposto}}
                          </div>
                          <div class="col-sm-6">
                            <b>Dependente para fins de Recebimento de Salário Família? </b>{{$dependente->salarioFamilia}}
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
                             <p> <b>NÃO EXISTE DEPENDENTE CADASTRADO!</b></p>
                          </div>
                        </div>
                      @endforelse
                </div>
            </div>
      </div>
   </div>
</div>
@endsection

