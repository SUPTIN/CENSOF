@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">

                    <div class="row">

                      <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('aceite')}}">
                            <img src="icones/Test.png" alt="Fichas para Avaliar"/>
                            <div class="caption">
                              <h4 align="center">Avaliar</h4>
                            </div>
                        </a>
                       </div>
                      </div>

                      <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('listaAvaliadores')}}">
                            <img src="icones/Gerente.png" alt="Lista avaliados com seus Avaliadores"/>
                            <div class="caption">
                              <h4 align="center">Avaliações</h4>
                            </div>
                        </a>
                       </div>
                      </div>

                      <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('secretarias')}}">
                            <img src="icones/setores.png" alt="Lista dos Setores"/>
                            <div class="caption">
                              <h4 align="center">Secretarias</h4>
                            </div>
                          </a>
                        </div>
                      </div>

                      <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('avaliados')}}">
                            <img src="icones/avaliados.png" alt="Lista dos Setores"/>
                            <div class="caption">
                              <h4 align="center">Avaliados</h4>
                            </div>
                          </a>
                        </div>
                      </div>
                      
                      </div>

                    </div>


                    <div class="row">
                      

                      <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('periodos')}}">
                            <img src="icones/periodo.png" alt="Período da Avaliação"/>
                            <div class="caption">
                              <h4 align="center">Período Avaliação</h4>
                            </div>
                        </a>
                       </div>
                      </div>

                     <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('logs')}}">
                            <img src="icones/log.png" alt="Log de Alteração"/>
                            <div class="caption">
                              <h4 align="center">Log de Alteração</h4>
                            </div>
                        </a>
                       </div>
                      </div>

                      <div class="col-sm-5 col-md-3">
                        <div class="thumbnail">
                          <a href="{{url('informacao')}}">
                            <img src="icones/Info.png" alt="sobre sistema"/>
                            <div class="caption">
                              <h4 align="center">Informações do Sistema</h4>
                            </div>
                        </a>
                       </div>
                     </div>

           </div>
      </div>
   </div>
</div>

@endsection

