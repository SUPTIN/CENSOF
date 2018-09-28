@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Dados Pessois</h4>
                        <h6>Passo 1 de 5 </h6>

                      </div>

                      <form method="post" action="iDP">
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
                        <div class="col-sm-6">
                          Secretaria: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="secretariaBase" value="{{$infoBase->secretariaBase}}" style="text-transform:uppercase" />
                        </div>
                        <div class="col-sm-6">
                          Local de Trabalho: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="localTrabBase" value="{{$infoBase->localTrabBase}}" style="text-transform:uppercase" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          Carga Horária: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="cargaHorariaBase" value="{{$infoBase->cargaHorariaBase}}" style="text-transform:uppercase" />
                        </div>
                        <div class="col-sm-6">
                          Horário e dias trabalhados: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="horarioTrabBase" value="{{$infoBase->horarioTrabBase}}" style="text-transform:uppercase" />
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Nome: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="nomeBase" value="{{$infoBase->nomeBase}}" style="text-transform:uppercase" />
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Data de Nascimento: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="dataNasc" name="dataNasc" value="{{$infoPessoais->dataNasc}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                         Sexo: <label style="font-size:15px;color:red;">*</label>
                         <select name="sexo" class="form-control">
                           <option value=" " {{$infoPessoais->sexo == " "? 'selected':' '}}></option>
                           <option value="MASCULINO" {{$infoPessoais->sexo == "MASCULINO"? 'selected':'MASCULINO'}}>MASCULINO</option>
                           <option value="FEMININO" {{$infoPessoais->sexo == "FEMININO"? 'selected':'FEMININO'}}>FEMININO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          País de Nascimento: <label style="font-size:15px;color:red;">*</label>
                          <select name="paisNasc"  id="paisNasc" onchange="optionCheck()" class="form-control">
                                <option value=" "></option>
                            @forelse($paises as $pais)
                                <option {{$infoPessoais->paisNasc == $pais->paisId ? 'selected':''}} value="{{$pais->paisId}}">{{$pais->paisNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <section id="estadosCidades">
                          
                        </section>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome de Mãe: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="nomeMae" value="{{$infoPessoais->nomeMae}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome de Pai:
                          <input class="form-control" name="nomePai" value="{{$infoPessoais->nomePai}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Estado Civil: <label style="font-size:15px;color:red;">*</label>
                          <select id="estadoCivil" name="estadoCivil"  onchange="dataCamento()" class="form-control">
                          <option value=""></option>
                           <option {{$infoPessoais->estadoCivil == "SOLTEIRO"? 'selected':'SOLTEIRO'}} value="SOLTEIRO">SOLTEIRO</option>
                           <option {{$infoPessoais->estadoCivil == "CASADO"? 'selected':'CASADO'}} value="CASADO">CASADO</option>
                           <option {{$infoPessoais->estadoCivil == "DIVORCIADO"? 'selected':'DIVORCIADO'}} value="DIVORCIADO">DIVORCIADO</option>
                           <option {{$infoPessoais->estadoCivil == "VIÚVO"? 'selected':'VIÚVO'}} value="VIÚVO">VIÚVO</option>
                           <option {{$infoPessoais->estadoCivil == "UNIÃO ESTAVÉL"? 'selected':'UNIÃO ESTAVÉL'}} value="UNIÃO ESTAVÉL">UNIÃO ESTAVÉL</option>
                           <option {{$infoPessoais->estadoCivil == "OUTRO"? 'selected':'OUTRO'}} value="OUTRO">OUTRO</option>
                         </select>
                        </div>
                        <div class="col-sm-6" id="campoEstadoCivil" style="display:none">
                          Data do Casamento:
                          <input class="form-control" id="dataCasamento" name="dataCasamento" value="{{$infoPessoais->dataCasamento}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row" id="campoNomeConjugue" style="display: none">
                        <div class="col-sm-12">
                          Nome do Conjuge:
                          <input class="form-control" name="nomeConjugue" value="{{$infoPessoais->nomeConjugue}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Raça/cor: <label style="font-size:15px;color:red;">*</label>
                          <select name="racaCor" class="form-control">
                            <option value=" " {{$infoPessoais->racaCor == " "? 'selected':' '}}> </option>
                           <option {{$infoPessoais->racaCor == "BRANCA"? 'selected':'BRANCA'}} value="BRANCA">BRANCA</option>
                           <option {{$infoPessoais->racaCor == "INDÍGENA"? 'selected':'INDÍGENA'}} value="INDÍGENA">INDÍGENA</option>
                           <option {{$infoPessoais->racaCor == "NEGRA"? 'selected':'NEGRA'}} value="NEGRA">NEGRA</option>
                           <option {{$infoPessoais->racaCor == "AMARELA"? 'selected':'AMARELA'}} value="AMARELA">AMARELA</option>
                           <option {{$infoPessoais->racaCor == "PARDA"? 'selected':'PARDA'}} value="PARDA">PARDA</option>
                           <option {{$infoPessoais->racaCor == "NÃO INFORMADO"? 'selected':'NÃO INFORMADO'}} value="NÃO INFORMADO">NÃO INFORMADO</option>
                         </select>
                        </div>
                        <div class="col-sm-6">
                          Tipo Sanguínio: <label style="font-size:15px;color:red;">*</label>
                          <select name="tipoSanguinio" class="form-control">
                           <option {{$infoPessoais->tipoSanguinio == " "? 'selected':' '}} value=" "> </option>
                           <option {{$infoPessoais->tipoSanguinio == "A+"? 'selected':'A+'}} value="A+">A+</option>
                           <option {{$infoPessoais->tipoSanguinio == "A-"? 'selected':'A-'}} value="A-">A-</option>
                           <option {{$infoPessoais->tipoSanguinio == "B+"? 'selected':'B+'}} value="B+">B+</option>
                           <option {{$infoPessoais->tipoSanguinio == "B-"? 'selected':'B-'}} value="B-">B-</option>
                           <option {{$infoPessoais->tipoSanguinio == "AB+"? 'selected':'AB+'}} value="AB+">AB+</option>
                           <option {{$infoPessoais->tipoSanguinio == "AB-"? 'selected':'AB-'}} value="AB-">AB-</option>
                           <option {{$infoPessoais->tipoSanguinio == "O+"? 'selected':'O+'}} value="O+">O+</option>
                           <option {{$infoPessoais->tipoSanguinio == "O-"? 'selected':'O-'}} value="O-">O-</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Escolaridade: <label style="font-size:15px;color:red;">*</label>
                          <select name="escolaridade" class="form-control">
                            <option value=""></option>
                            @forelse($escolaridades as $escolaridade)
                              <option {{$infoPessoais->escolaridade == $escolaridade->id ? 'selected':''}} value="{{$escolaridade->id}}">{{$escolaridade->descricaoEscolaridade}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-6">
                          Área de Instrução: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="areaInstrucao" value="{{$infoPessoais->areaInstrucao}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Estrangeiro: <label style="font-size:15px;color:red;">*</label>
                          <select id="estrangeiro" name="estrangeiro" onChange="dataChegadaBrasilEst()" class="form-control">
                           <option {{$infoPessoais->estrangeiro == " "? 'selected':' '}} value=" "> </option>
                           <option {{$infoPessoais->estrangeiro == "SIM"? 'selected':'SIM'}} value="SIM">SIM</option>
                           <option {{$infoPessoais->estrangeiro == "NÃO"? 'selected':'NÃO'}} value="NÃO">NÃO</option>
                         </select>
                        </div>
                        <div id="campoDataChegadaBrasil" class="col-sm-6" style="display: none">
                          Data de Chegada ao Brasil:
                          <input class="form-control" id="dataChegadaBrasil" name="dataChegadaBrasil" value="{{$infoPessoais->dataChegadaBrasil}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Naturalizado: <label style="font-size:15px;color:red;">*</label>
                          <select id="naturalizado" name="naturalizado" onChange="dataNaturalizacao()" class="form-control">
                           <option {{$infoPessoais->naturalizado == " "? 'selected':' '}} value=" "> </option>
                           <option {{$infoPessoais->naturalizado == "SIM"? 'selected':'SIM'}} value="SIM">SIM</option>
                           <option {{$infoPessoais->naturalizado == "NÃO"? 'selected':'NÃO'}} value="NÃO">NÃO</option>
                         </select>
                        </div>
                        <div id="campoNaturalizado"  name="campoNaturalizado" class="col-sm-6" style="display: none">
                          Data da Naturalizaçao:
                          <input class="form-control" id="dataNaturalizado"  name="dataNaturalizado" value="{{$infoPessoais->dataNaturalizado}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Possui algum tipo de deficiência: <label style="font-size:15px;color:red;">*</label>
                          <select  id="possuiDeficiencia"name="possuiDeficiencia" onchange="possuiTipoDeficiencia()" class="form-control">
                           <option {{$infoPessoais->possuiDeficiencia == " "? 'selected':' '}} value=" "> </option>
                           <option {{$infoPessoais->possuiDeficiencia == "SIM"? 'selected':'SIM'}} value="SIM">SIM</option>
                           <option {{$infoPessoais->possuiDeficiencia == "NÃO"? 'selected':'NÃO'}} value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>
                      <div class="row" id="campoQual" style="display: none">
                        <div class="col-sm-12">
                          Qual?
                         <select id="qualDeficiencia" name="qualDeficiencia"  class="form-control">
                           <option {{$infoPessoais->qualDeficiencia == " "? 'selected':' '}} value=" "> </option>
                           <option {{ $infoPessoais->qualDeficiencia == 'FÍSICA' ? 'selected' : '' }} value="FÍSICA">FÍSICA</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'AUDITIVA' ? 'selected' : '' }} value="AUDITIVA">AUDITIVA</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'VISUAL' ? 'selected' : '' }} value="VISUAL">VISUAL</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'MENTAL' ? 'selected' : '' }} value="MENTAL">MENTAL</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'MÚLTIPLAS' ? 'selected' : '' }} value="MÚLTIPLAS">MÚLTIPLAS</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'REABILITADO' ? 'selected' : '' }} value="REABILITADO">REABILITADO</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'INTELECTUAL' ? 'selected' : '' }} value="INTELECTUAL">INTELECTUAL</option>
                           <option {{ $infoPessoais->qualDeficiencia == 'NÃO NECESSÁRIO' ? 'selected' : '' }} value="NÃO NECESSÁRIO">NÃO INFORMADO</option>
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
       function optionCheck(){
         var option = document.getElementById("paisNasc").value;
         if (option != '33'){

           var inputText = '<div class="col-sm-4" id="estadoNascCamp">Estado de Nascimento: <label style="font-size:15px;color:red;">*</label> <input class="form-control" name="estadoNasc"  value="{{$infoPessoais->estadoNasc}}" style="text-transform:uppercase"/></div> <div class="col-sm-4" id="cidadeNascCamp"> Cidade de Nascimento: <label style="font-size:15px;color:red;">*</label> <input class="form-control" name="cidadeNasc" value="{{$infoPessoais->cidadeNasc}}" style="text-transform:uppercase"/></div>'; 
           $('#estadoNascCamp').remove();
           $('#cidadeNascCamp').remove();
           $('#estadosCidades').append(inputText);
    
         }else{
           var inputText = '<div class="col-sm-4" id="estadoNascCamp">Estado de Nascimento: <label style="font-size:15px;color:red;">*</label> <select name="estadoNasc"  id="estadoNasc" class="form-control" onchange="optionCidades()"> <option {{$infoPessoais->estadoNasc == " "? 'selected':' '}}value=""></option>@forelse($estados as $estado)<option {{$infoPessoais->estadoNasc == $estado->estadoId? 'selected':' '}} value="{{$estado->estadoId}}">{{$estado->estadoUf}}</option>@empty<option value="0">Nenhum resultado encontrado!</option>@endforelse</select></div><div class="col-sm-4" id="cidadeNascCamp">Cidade de Nascimento: <label style="font-size:15px;color:red;">*</label><select name="cidadeNasc"  id="cidadeNasc" class="form-control"></div>'; 
           $('#estadoNascCamp').remove();
           $('#cidadeNascCamp').remove();
           $('#estadosCidades').append(inputText);
         }
       }

       function optionCidades(){
          var es = document.getElementById("estadoNasc").value;
          url = "{{action('censoController@getCidades')}}";
          $.get(url, {es: es},function (cidades){
           $('select[name=cidadeNasc]').empty();
           $('select[name=cidadeNasc]').append("<option value='' disable style='display:nome;'> Selecione uma cidade</option>");
           $.each(cidades, function (key, value){
             $('select[name=cidadeNasc]').append('<option {{$infoPessoais->cidadeNasc == '+value.cidadeId+'? 'selected':''}} value='+value.cidadeId+'>'+value.cidadeNome+'</option>');
           }); 
         }); 
        }
        
        function dataCamento(){
         var $estadoCivil = document.getElementById("estadoCivil").value;
         
         if ($estadoCivil == 'CASADO'){
           $('#campoEstadoCivil').show();
           $('#campoNomeConjugue').show();
           var $dataCasamento = $("#dataCasamento");
           $dataCasamento.mask('00/00/0000',{reverse: true});
         }else{
           $('#campoEstadoCivil').hide();
           $('#campoNomeConjugue').hide();
           $dataCasamento = 'NÃO NECESSÁRIO.';
         }
        }

        function possuiTipoDeficiencia(){
         var $possuiDeficiencia = document.getElementById("possuiDeficiencia").value;
         if ($possuiDeficiencia == 'SIM'){
           $('#campoQual').show();
         }else{
           $('#campoQual').hide();
           $qualDeficiencia = 'CAMPO NÃO NECESSÁRIO.'
         }
        }

        function dataChegadaBrasilEst(){
         var $estrangeiro = document.getElementById("estrangeiro").value;
         if ($estrangeiro == 'SIM'){
           $('#campoDataChegadaBrasil').show();
           var $dataChegadaBrasil = $("#dataChegadaBrasil");
           $dataChegadaBrasil.mask('00/00/0000',{reverse: true});
         }else{
           $('#campoDataChegadaBrasil').hide();
           $dataChegadaBrasil = 'CAMPO NÃO NECESSÁRIO.'
         }
        }

        function dataNaturalizacao(){
         var $naturalizado = document.getElementById("naturalizado").value;
         if ($naturalizado == 'SIM'){
           $('#campoNaturalizado').show();
           var $dataNaturalizado = $("#dataNaturalizado");
           $dataNaturalizado.mask('00/00/0000',{reverse: true});
         }else{
           $('#campoNaturalizado').hide();
           $dataNaturalizado = 'CAMPO NÃO NECESSÁRIO.'
         }
        }

       $(document).ready(function(){
         var $dataNasc = $("#dataNasc");
         $dataNasc.mask('00/00/0000',{reverse: true});
         dataNaturalizacao();
         dataChegadaBrasilEst();
         possuiTipoDeficiencia();
         dataCamento();
         optionCheck();
         optionCidades();
       });

     </script>
   </div>

</div>
@endsection

