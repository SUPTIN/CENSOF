@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Vínculo Empregatício / Função Gratificada </h4>
                        <h6>Passo 4 de 6</h6>
                      </div>

                      <form method="post" action="iVinculo" autocomplete="off">
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" type="hidden" name="_token" value="{{ csrf_token()}}"/>
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
                          <h4>Vínculo Prefeitura Municipal de Santa Maria de Jetibá:</h4>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                         Possui cargo ou função gratificada? <label style="font-size:15px;color:red;">*</label>
                          <select id="funcaoGratificada" name="funcaoGratificada" onchange="possuiGratificacao()" class="form-control">
                          <option value=""></option>
                           <option {{ old('funcaoGratificada') == 'SIM' ? 'selected' : '' }} value="SIM">SIM</option>
                           <option {{ old('funcaoGratificada') == 'NÃO' ? 'selected' : '' }} value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row" id="campoQual" style="display: none">
                        <div class="col-sm-12">
                          Cargo gratificado:
                          <input class="form-control" name="cargoGratificado" value="{{old('cargoGratificado')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <br/>
                          <h4>Outro vínculo:</h4>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-8">
                          Possui vínculo empregatício em outro Orgão? <label style="font-size:15px;color:red;">*</label>
                          <select name="vinculoEmpregaticio" id="vinculoEmpregaticio" onchange="optionVE()" class="form-control">
                            <option value=" "> </option>
                           <option {{ old('vinculoEmpregaticio') == 'SIM' ? 'selected' : '' }} value="SIM">SIM</option>
                           <option {{ old('vinculoEmpregaticio') == 'NÃO' ? 'selected' : '' }} value="NÃO">NÃO</option>
                         </select>
                        </div>
                        <div class="col-sm-4" id="campoQualV" style="display: none">
                          Qual?
                          <select name="qualVinculo" class="form-control">
                            <option value=" "> </option>
                           <option {{ old('qualVinculo') == 'MUNICIPAL' ? 'selected' : '' }} value="MUNICIPAL">MUNICIPAL</option>
                           <option {{ old('qualVinculo') == 'ESTADUAL' ? 'selected' : '' }} value="ESTADUAL">ESTADUAL</option>
                           <option {{ old('qualVinculo') == 'FEDERAL' ? 'selected' : '' }} value="FEDERAL">FEDERAL</option>
                           <option {{ old('qualVinculo') == 'EMPRESA PRIVADA' ? 'selected' : '' }} value="EMPRESA PRIVADA">EMPRESA PRIVADA</option>
                         </select>
                        </div>
                      </div>

                      <div class="row" id="campoOrgaoV" style="display: none">
                        <div class="col-sm-12">
                          Órgão empregatício:
                          <input class="form-control" name="orgaoEmpregaticio" value="{{old('orgaoEmpregaticio')}}" style="text-transform:uppercase" />
                        </div>
                      </div>
                      <div class="row" id="campoCargoV" style="display: none">
                        <div class="col-sm-6">
                          Cargo:
                          <input class="form-control" name="cargoVinculo" value="{{old('cargoVinculo')}}" style="text-transform:uppercase" />
                        </div>
                        <div class="col-sm-6">
                          Carga horária:
                          <input class="form-control" name="cargaHorariaVinculo" value="{{old('cargaHorariaVinculo')}}" style="text-transform:uppercase" />
                        </div>
                      </div>
                      <div class="row" id="campoTurnoV" style="display: none"i>
                        <div class="col-sm-6">
                          Turno:
                          <input class="form-control" name="turnoVinculo" value="{{old('turnoVinculo')}}" style="text-transform:uppercase" />
                        </div>
                        <div class="col-sm-6" id="campoDiasV" style="display: none">
                          Horário e dias trabalhados:
                          <input class="form-control" name="horarioDiasTrabVinculo" value="{{old('horarioDiasTrabVinculo')}}" style="text-transform:uppercase" />
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <br/>
                        </div>
                      </div>

                      <div class="row" align="center">
                        <div class="col-sm-12"> 
                          <button class="btn btn-primary">Avançar</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
      </div>
   </div>

   <div>
     
     <script type="text/javascript">

        function optionVE(){
            var $vinculoEmpregaticio = document.getElementById("vinculoEmpregaticio").value;
            if ($vinculoEmpregaticio == 'SIM'){
               $qualVinculo = '';
               $orgaoEmpregaticio = '';
               $cargoVinculo = '';
               $cargaHorariaVinculo = '';
               $horarioDiasTrabVinculo = '';
               $turnoVinculo = '';
               $('#campoQualV').show();
               $('#campoOrgaoV').show();
               $('#campoCargoV').show();
               $('#campoTurnoV').show();
               $('#campoDiasV').show();
            }else{
               $('#campoQualV').hide();
               $('#campoOrgaoV').hide();
               $('#campoCargoV').hide();
               $('#campoTurnoV').hide();
               $('#campoDiasV').hide();
               $qualVinculo = 'NÃO NECESSÁRIO';
               $orgaoEmpregaticio = 'NÃO NECESSÁRIO';
               $cargoVinculo = 'NÃO NECESSÁRIO';
               $cargaHorariaVinculo = 'NÃO NECESSÁRIO';
               $horarioDiasTrabVinculo = 'NÃO NECESSÁRIO';
               $turnoVinculo = 'NÃO NECESSÁRIO';
            }
        }

        function possuiGratificacao(){
         var $funcaoGratificada = document.getElementById("funcaoGratificada").value;
         if ($funcaoGratificada == 'SIM'){
           $('#campoQual').show();
         }else{
           $('#campoQual').hide();
           $cargoGratificado = 'NÃO NECESSÁRIO';
         }
        }


        $(document).ready(function(){
         possuiGratificacao();
         optionVE();
         
       });

     </script>
   </div>

</div>
@endsection

