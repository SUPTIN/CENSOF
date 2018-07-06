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

                      <form method="post" action="dep">
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" type="hidden" name="_token" value="{{ csrf_token()}}" style="text-transform:uppercase"/>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Nome: 
                          <input class="form-control" name="nomeDependente" value="{{old('nomeDependente')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Data de Nascimento:
                          <input class="form-control" name="dataNascDependente" value="{{old('dataNascDependete')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                         Sexo:
                         <select name="sexoDependente" class="form-control">
                           <option value=""></option>
                           <option value="MASCULINO">MASCULINO</option>
                           <option value="FEMININO">FEMININO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Grau de Parentesco:
                          <input class="form-control" name="parentesco" value="{{old('parentesco')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                          CPF:
                          <input class="form-control" name="cpfDependente" value="{{old('cpfDependente')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Estado Cívil:
                          <select name="estadoCivilDependente" class="form-control">
                          <option value=""></option>
                           <option value="SOLTEIRO">SOLTEIRO</option>
                           <option value="CASADO">CASADO</option>
                           <option value="DIVORCIADO">DIVORCIADO</option>
                           <option value="VIÚVO">VIÚVO</option>
                           <option value="UNIÃO ESTAVÉL">UNIÃO ESTAVÉL</option>
                           <option value="OUTRO">OUTRO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Dependente para fins de Dedução de Imposto de renda?
                          <select name="deducaoImposto" class="form-control">
                           <option value=""></option>
                           <option value="SIM">SIM</option>
                           <option value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Dependente para fins de Recebimento de Salário Família?
                          <select name="salarioFamilia" class="form-control">
                           <option value=""></option>
                           <option value="SIM">SIM</option>
                           <option value="NÃO">NÃO</option>
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

