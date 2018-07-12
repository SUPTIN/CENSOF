@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Dependentes</h4>
                        <h6>Passo 4 de 4</h6>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a href="novoDependente"> 
                             Adicionar novo Dependente <i class="fa fa-plus-circle" aria-hidden="true" title="Adicionar um Dependente"> </i>
                          </a> &nbsp;
                          <a href="impressaoFichas"> 
                             Finalizar e Imprimir comprovantes <i class="fa fa-print" aria-hidden="true" title="Adicionar um Dependente"> </i>
                          </a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <table class="table table-hover">
                            <tr>
                              <tH>Nome</td>
                              <tH>CPF</td>
                              <tH>Data Nasc.</td>
                              <tH>Ação</td>
                            </tr>
                            @forelse($dependentes as $dependente)
                              <tr>
                                <td >{{$dependente->nomeDependente}}</td>
                                <td width="80px">{{$dependente->cpfDependente}}</td>
                                <td width="80px">{{$dependente->dataNascDependente}}</td>
                                <td width="80px">
                                  <a href="{{url("$dependente->idDependente/editDependente")}}" class="edit">
                                     <li class="fa fa-pencil-square-o" title="Editar Dependente"></li>
                                  </a>
                                  <a href="{{url("$dependente->idDependente/delDependente")}}" class="delete">
                                     <li class="fa fa-eraser" title="Deleta Dependente"></li>
                                  </a>
                                </td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="3"> <p> Não existe Dependente cadastrado!</p></td>
                              </tr>
                            @endforelse
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <div align="center">{!! $dependentes->links() !!}</div>
                        </div>
                      </div>
                </div>
            </div>
      </div>
   </div>
</div>
@endsection

