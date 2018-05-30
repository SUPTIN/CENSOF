@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Endereço e Contatos </h4>
                        <h6>Passo 2 de 4</h6> 
                      </div>

                      <div class="row">
                        <div class="col-sm-10">
                          Endereço Residencial: 
                          <input class="form-control" name="enderecoResidencial" value="{{old('enderecoResidencial')}}"/>
                        </div>
                        <div class="col-sm-2">
                          Número:
                          <input class="form-control" name="numero" value="{{old('numero')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Complemento:
                          <input class="form-control" name="complemento" value="{{old('complemento')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Cidade:
                          <input class="form-control" name="cidade" value="{{old('cidade')}}"/>
                        </div>
                        <div class="col-sm-6">
                          Bairro:
                          <input class="form-control" name="bairro" value="{{old('bairro')}}"/>
                        </div>
                        
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Estado:
                          <input class="form-control" name="cep" value="{{old('cep')}}"/>
                        </div>
                        <div class="col-sm-6">
                          CEP:
                          <input class="form-control" name="estadoResidencia" value="{{old('estadoResidencia')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Tel. Residencial:
                          <input class="form-control" name="telResidencial" value="{{old('telResidencial')}}"/>
                        </div>
                        <div class="col-sm-6">
                          Tel. Celular:
                          <input class="form-control" name="telCelular" value="{{old('telCelular')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        
                        <div class="col-sm-12">
                          E-mail:
                          <input class="form-control" name="email" value="{{old('email')}}"/>
                        </div>
                      </div>

                      <div class="row" align="center">
                        <div class="col-sm-12">
                          <a href="documentacao"> Proximo passo</a>
                        </div>
                      </div>

                </div>
            </div>
      </div>
   </div>
</div>
@endsection

