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

                      <form method="post" action="iVinculo">
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
                        <div class="col-sm-8">
                          Possui vínculo empregatício em outro Orgão? <label style="font-size:15px;color:red;">*</label>
                          <select name="vinculoEmpregaticio" class="form-control">
                            <option value=" "> </option>
                           <option {{ old('vinculoEmpregaticio') == 'SIM' ? 'selected' : '' }} value="SIM">SIM</option>
                           <option {{ old('vinculoEmpregaticio') == 'NÃO' ? 'selected' : '' }} value="NÃO">NÃO</option>
                         </select>
                        </div>
                        <div class="col-sm-4">
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

                      <div class="row">
                        <div class="col-sm-12">
                          Órgão empregatício:
                          <input class="form-control" name="orgaoEmpregaticio" value="{{old('orgaoEmpregaticio')}}" style="text-transform:uppercase" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Cargo:
                          <input class="form-control" name="cargoVinculo" value="{{old('cargoVinculo')}}" style="text-transform:uppercase" />
                        </div>
                        <div class="col-sm-6">
                          Carga horária:
                          <input class="form-control" name="cargaHorariaVinculo" value="{{old('cargaHorariaVinculo')}}" style="text-transform:uppercase" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Turno:
                          <input class="form-control" name="turnoVinculo" value="{{old('turnoVinculo')}}" style="text-transform:uppercase" />
                        </div>
                        <div class="col-sm-6">
                          Horário e dias trabalhados:
                          <input class="form-control" name="horarioDiasTrabVinculo" value="{{old('horarioDiasTrabVinculo')}}" style="text-transform:uppercase" />
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                         Possui cargo ou função gratificada? <label style="font-size:15px;color:red;">*</label>
                          <select id="funcaoGratificada" name="funcaoGratificada" class="form-control">
                          <option value=""></option>
                           <option {{ old('funcaoGratificada') == 'SIM' ? 'selected' : '' }} value="SIM">SIM</option>
                           <option {{ old('funcaoGratificada') == 'NÃO' ? 'selected' : '' }} value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row" >
                        <div class="col-sm-12">
                          Cargo gratificado:
                          <input class="form-control" name="cargoGratificado" value="{{old('cargoGratificado')}}" style="text-transform:uppercase"/>
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

        function possuiTipoDeficiencia(){
         var $possuiDeficiencia = document.getElementById("possuiDeficiencia").value;
         if ($possuiDeficiencia == 'SIM'){
           $('#campoQual').show();
         }else{
           $('#campoQual').hide();
           $qualDeficiencia = 'NÃO NECESSÁRIO.'
         }
        }

     </script>
   </div>

</div>
@endsection

