@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Prefeitura de Santa Maria de Jetibá, ES</h4>
                      </div>

                      <div class="row">
                        <div class="col-sm-8">
                          Nome: {{$dBasicos->nomeBase}}
                        </div>

                        <div class="col-sm-4">
                          Matrícula: {{$dBasicos->matriculaBase}}
                        </div>
                      </div>

                      <div class="row">
                         <div class="col-sm-6 ">
                          Cargo: {{$dBasicos->cargoBase}}
                        </div>
                        <div class="col-sm-6">
                         Data de Admissão: {{$dBasicos->admissaoBase}}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6 col-md-6">
                         Secretaria de Lotação: {{$dBasicos->secretariaBase}}
                        </div>
                      </div>

                      <div class="row" align="center">
                        <div class="col-sm-12">
                          <a href="{{url("$dBasicos->idDadosBase/dadosPessoais")}}"> Iniciar Censo <i class="fa fa-edit" aria-hidden="true" title="Iniciar Cadastro"> </i>
                          </a>
                        </div>
                        <div class="col-sm-12">
                          <a href="{{url("$dBasicos->idDadosBase/impressaoFichas")}}"> Conferência e Impressão de Ficha  <i class="fa fa-print" aria-hidden="true" title="Finalizar e impressão"> </i>
                          </a>
                        </div>
                      </div>
                  </div>
            </div>
        </div>
   </div>
</div>
@endsection

