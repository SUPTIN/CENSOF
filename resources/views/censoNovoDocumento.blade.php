@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Anexar Novo Documento</h4>
                      </div>

                      <form method="post" action="insereArq" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" type="hidden" name="_token" value="{{ csrf_token()}}" style="text-transform:uppercase"/>
                        </div>
                        @if (isset($errors) && count($errors) > 0)
                          <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                               <ul>
                                 <li> {{$error}}</li>
                               </ul>
                            @endforeach
                          </div>
                        @endif
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          <label style="font-size:10px;color:red;"> * Campo de preenchimento Obrigatório.</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-8">
                          Documento: <label style="font-size:15px;color:red;">*</label>
                          <input  type="file" name="arquivoDoc"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                         Tipo Doc.: <label style="font-size:15px;color:red;">*</label>
                         <select name="tipoDocumento" class="form-control">
                           <option value=""></option>
                           <option value="CPF" {{ old('tipoDocumento') == 'CPF' ? 'selected' : '' }} >CPF</option>
                           <option value="RG" {{ old('tipoDocumento') == 'RG' ? 'selected' : '' }}>RG</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <br/>
                        </div>
                      </div>
                      <div class="row" align="center">
                        <div class="col-sm-12"> 
                          <button class="btn btn-primary">Adicionar</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
      </div>
   </div>
</div>
@endsection

