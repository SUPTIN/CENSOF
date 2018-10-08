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

                      <form method="post" action="dep" autocomplete="off">
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
                        <div class="col-sm-12">
                          Nome: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="nomeDependente" value="{{old('nomeDependente')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Data de Nascimento: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="dataNascDependente" name="dataNascDependente" value="{{old('dataNascDependente')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                         Sexo: <label style="font-size:15px;color:red;">*</label>
                         <select name="sexoDependente" class="form-control">
                           <option value=""></option>
                           <option value="MASCULINO" {{ old('sexoDependente') == 'MASCULINO' ? 'selected' : '' }} >MASCULINO</option>
                           <option value="FEMININO" {{ old('sexoDependente') == 'FEMININO' ? 'selected' : '' }}>FEMININO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Grau de Parentesco: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="parentesco" value="{{old('parentesco')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                          CPF: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="cpfDependente" name="cpfDependente" value="{{old('cpfDependente')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Estado Cívil: <label style="font-size:15px;color:red;">*</label>
                          <select name="estadoCivilDependente" class="form-control">
                          <option value=""></option>
                           <option {{ old('estadoCivilDependente') == 'SOLTEIRO' ? 'selected' : '' }} value="SOLTEIRO">SOLTEIRO</option>
                           <option {{ old('estadoCivilDependente') == 'CASADO' ? 'selected' : '' }} value="CASADO">CASADO</option>
                           <option {{ old('estadoCivilDependente') == 'DIVORCIADO' ? 'selected' : '' }} value="DIVORCIADO">DIVORCIADO</option>
                           <option {{ old('estadoCivilDependente') == 'VIÚVO' ? 'selected' : '' }} value="VIÚVO">VIÚVO</option>
                           <option {{ old('estadoCivilDependente') == 'UNIÃO ESTAVÉL' ? 'selected' : '' }} value="UNIÃO ESTAVÉL">UNIÃO ESTAVÉL</option>
                           <option {{ old('estadoCivilDependente') == 'OUTRO' ? 'selected' : '' }} value="OUTRO">OUTRO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Dependente para fins de Dedução de Imposto de renda? <label style="font-size:15px;color:red;">*</label>
                          <select name="deducaoImposto" class="form-control">
                           <option value=""></option>
                           <option {{ old('deducaoImposto') == 'SIM' ? 'selected' : '' }}  value="SIM">SIM</option>
                           <option {{ old('deducaoImposto') == 'NÃO' ? 'selected' : '' }} value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Dependente para fins de Recebimento de Salário Família? <label style="font-size:15px;color:red;">*</label>
                          <select name="salarioFamilia" class="form-control">
                           <option value=""></option>
                           <option  {{ old('salarioFamilia') == 'SIM' ? 'selected' : '' }} value="SIM">SIM</option>
                           <option {{ old('salarioFamilia') == 'NÃO' ? 'selected' : '' }} value="NÃO">NÃO</option>
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
      <script type="text/javascript">
        $(document).ready(function(){

         var $cpfDependente = $("#cpfDependente");
         $cpfDependente.mask('000.000.000-00',{reverse: true});

         var $dataNascDependente = $("#dataNascDependente");
         $dataNascDependente.mask('00/00/0000',{reverse: true});

        });

     </script>
   </div>
</div>
@endsection

