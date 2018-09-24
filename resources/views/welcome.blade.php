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

                      @forelse($dBasicos as $dBasico)

                      <div class="row">
                        <div class="col-sm-8">
                          Nome: {{$dBasicos[0]->nomeBase}}
                        </div>

                        <div class="col-sm-4">
                          Matrícula: {{$dBasico->matriculaBase}}
                        </div>
                      </div>

                      <div class="row">
                         <div class="col-sm-6 ">
                          Cargo: {{$dBasico->cargoBase}}
                        </div>
                        <div class="col-sm-6">
                         Data de Admissão: {{$dBasico->admissaoBase}}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6 col-md-6">
                         Secretaria de Lotação: {{$dBasico->secretariaBase}}
                        </div>
                      </div>

                      <div class="row" align="center">

                        @if (  Auth::user()->trocaSenha == 0 )
                          <div class="col-sm-12">
                            <a href="{{url("/trocaSenha")}}"> Troca Senha <i class="fa fa-edit" aria-hidden="true" title="Troca Senha"> </i>
                            </a>
                          </div>
                        @else
                          <div class="col-sm-12">
                            <a href="{{url("$dBasico->idDadosBase/dadosPessoais")}}"> Iniciar Censo <i class="fa fa-edit" aria-hidden="true" title="Iniciar Cadastro"> </i>
                            </a>
                          </div>
                          <div class="col-sm-12">
                            <a href="{{url("$dBasico->idDadosBase/impressaoFichas")}}"> Conferência e Impressão de Ficha  <i class="fa fa-print" aria-hidden="true" title="Finalizar e impressão"> </i>
                            </a>
                          </div>
                        @endif

                        @empty
                          <div class="col-sm-12">
                            <p> Nenhum resultado encontrado!</p>
                          
                          </div>
                        @endforelse
                      </div>
                  </div>
            </div>
        </div>
   </div>
</div>
@endsection

