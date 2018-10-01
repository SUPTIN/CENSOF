@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Documentos anexados</h4>
                        <h6>Passo 5 de 6</h6>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a href="novoDocumento"> 
                             Anexar novo Documento <i class="fa fa-plus-circle" aria-hidden="true" title="Adicionar um Documento"> </i>
                          </a> &nbsp; 
                          <a href="arquivosRegras"> 
                             Orientenções para anexo dos Arquivos <i class="fa fa-eye" aria-hidden="true" title="Orientenções para anexo dos Arquivos"> </i>
                          </a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <table class="table table-hover">
                            <tr>
                              <tH>Arquivo</td>
                              <tH>Tipo Documento</td>
                              <tH>Ações</td>
                            </tr>
                            @forelse($arquivos as $arquivo)
                              <tr>
                                <td >{{$arquivo->nomeArquivo}}</td>
                                <td >{{$arquivo->tipoDocumento}}</td>
                                <td width="80px">
                                  <a href="{{url("$arquivo->idArquivo/delArquivo")}}" class="delete">
                                     <li class="fa fa-eraser" title="Deleta Arquivo"></li>
                                  </a>
                                  <a target="_blank" href="{{url("$arquivo->idArquivo/viewArquivo")}}" class="delete">
                                     <li class="fa fa-eye" title="Mostra Arquivo"></li>
                                  </a>
                                </td>
                              </tr>
                            @empty
                              <tr>
                                <td colspan="3"> <p> Não existe Documentos Anexados!</p></td>
                              </tr>
                            @endforelse
                          </table>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-sm-12">
                          <div align="center">{!! $arquivos->links() !!}</div>
                        </div>
                      </div>
                      <div class="row" align="center">
                        <div class="col-sm-12"> 
                          <a href="impressaoFichas" class="btn btn-primary"> 
                             Finalizar e Imprimir comprovante <i aria-hidden="true" title="Finalizar e Imprimir comprovante"> </i>
                          </a>
                        </div>
                      </div>
                </div>
            </div>
      </div>
   </div>
</div>
@endsection

