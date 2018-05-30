@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Adicionando Dependente</h4>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome: 
                          <input class="form-control" name="nomeDependente" value="{{old('nomeDependente')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Data de Nascimento:
                          <input class="form-control" name="dataNascDependete" value="{{old('dataNascDependete')}}"/>
                        </div>
                        <div class="col-sm-6">
                         Sexo:
                         <input class="form-control" name="sexoDependente" value="{{old('sexoDependente')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Grau de Parentesco:
                          <input class="form-control" name="parentesco" value="{{old('parentesco')}}"/>
                        </div>
                        <div class="col-sm-6">
                          CPF:
                          <input class="form-control" name="cpfDependente" value="{{old('cpfDependente')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Estado Cívil:
                          <input class="form-control" name="estadoCivilDependente" value="{{old('estadoCivilDependente')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Dependente para fins de Dedução de Imposto de renda?
                          <input class="form-control" name="deducaoImposto" value="{{old('deducaoImposto')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Dependente para fins de Recebimento de Salário Família?
                          <input class="form-control" name="salarioFamilia" value="{{old('salarioFamilia')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a href="dependentes"> Adicionar</a>
                        </div>
                      </div>

                </div>
            </div>
      </div>
   </div>
</div>
@endsection

