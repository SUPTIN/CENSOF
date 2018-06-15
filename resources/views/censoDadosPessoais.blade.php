@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Dados Pessois</h4>
                        <h6>Passo 1 de 4</h6>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome: 
                          <input class="form-control" name="nome" value="{{old('nome')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Data de Nascimento:
                          <input class="form-control" name="dataNasc" value="{{old('dataNasc')}}"/>
                        </div>
                        <div class="col-sm-6">
                         Sexo:
                         <select name="sexo" class="form-control">
                           <option value=""></option>
                           <option value="MASCULINO">MASCULINO</option>
                           <option value="FEMININO">FEMININO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          País de Nascimento:
                          <select name="paisNasc"  id="paisNasc" onchange="optionCheck()" class="form-control">
                                <option value=""></option>
                            @forelse($paises as $pais)
                                <option value="{{$pais->paisId}}">{{$pais->paisNome}}</option>
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
                          Nome de Mãe:
                          <input class="form-control" name="nomeMae" value="{{old('nomeMae')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome de Pai:
                          <input class="form-control" name="nomePai" value="{{old('nomePai')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Estado Civil:
                          <select name="estadoCivil" class="form-control">
                          <option value=""></option>
                           <option value="SOLTEIRO">SOLTEIRO</option>
                           <option value="CASADO">CASADO</option>
                           <option value="DIVORCIADO">DIVORCIADO</option>
                           <option value="VIÚVO">VIÚVO</option>
                           <option value="UNIÃO ESTAVÉL">UNIÃO ESTAVÉL</option>
                           <option value="OUTRO">OUTRO</option>
                         </select>
                        </div>
                        <div class="col-sm-6">
                          Data do Casamento:
                          <input class="form-control" name="dataCasa" value="{{old('dataCasa')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome do Conjuge:
                          <input class="form-control" name="nomeConjugue" value="{{old('nomeConjugue')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Raça/cor:
                          <select name="racaCor" class="form-control">
                            <option value=""></option>
                           <option value="BRANCA">BRANCA</option>
                           <option value="INDÍGENA">INDÍGENA</option>
                           <option value="NEGRA">NEGRA</option>
                           <option value="AMARELA">AMARELA</option>
                           <option value="PARDA">PARDA</option>
                           <option value="NÃO INFORMADO">NÃO INFORMADO</option>
                         </select>
                        </div>
                        <div class="col-sm-6">
                          Tipo Sanguínio:
                          <select name="tipoSanguinio" class="form-control">
                           <option value=""></option>
                           <option value="A+">A+</option>
                           <option value="A-">A-</option>
                           <option value="B+">B+</option>
                           <option value="B-">B-</option>
                           <option value="AB+">AB+</option>
                           <option value="AB-">AB-</option>
                           <option value="O+">O+</option>
                           <option value="O-">O-</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Escolaridade:
                          <select name="escolaridade" class="form-control">
                            <option value=""></option>
                            @forelse($escolaridades as $escolaridade)
                              <option value="{{$escolaridade->id}}">{{$escolaridade->descricaoEscolaridade}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-6">
                          Área de Instrução:
                          <input class="form-control" name="areaInstrucao" value="{{old('areaInstrucao')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Estrangeiro:
                          <select name="estrangeiro" class="form-control">
                           <option value=""></option>
                           <option value="SIM">SIM</option>
                           <option value="NÃO">NÃO</option>
                         </select>
                        </div>
                        <div class="col-sm-6">
                          Data de Chegada ao Brasil:
                          <input class="form-control" name="dataChegadaBrasil" value="{{old('dataChegadaBrasil')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Naturalizado:
                          <select name="naturalizado" class="form-control">
                           <option value=""></option>
                           <option value="SIM">SIM</option>
                           <option value="NÃO">NÃO</option>
                         </select>
                        </div>
                        <div class="col-sm-6">
                          Data da Naturalizaçao:
                          <input class="form-control" name="dataNaturalizado" value="{{old('dataNaturalizado')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Possui algum tipo de deficiência:
                          <select name="possuiDeficiencia" class="form-control">
                           <option value=""></option>
                           <option value="SIM">SIM</option>
                           <option value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          Qual?
                          <input class="form-control" name="qualDeficiencia" value="{{old('qualDeficiencia')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          
                          <a href="enderecoContatos"> Proximo passo</a>
                        </div>
                      </div>

                </div>
            </div>
      </div>
   </div>

   <div>
     <script type="text/javascript">
       function optionCheck(){
         var option = document.getElementById("paisNasc").value;
         if (option != '33'){

           var inputText = '<div class="col-sm-4" id="estadoNasc">Estado: <input class="form-control" name="estadoNasc"  value="{{old('estado')}}"/></div> <div class="col-sm-4" id="cidadeNasc"> Cidade de Nascimento:<input class="form-control" name="cidadeNasc" value="{{old('cidadeNasc')}}"/></div>'; 
           $('#estadoNasc').remove();
           $('#cidadeNasc').remove();
           $('#estadosCidades').append(inputText);
    
         }else{
           var inputText = '<div class="col-sm-4" id="estadoNasc">Estado:<select name="estado"  id="estado" class="form-control" onchange="optionCidades()"><option value=""></option>@forelse($estados as $estado)<option value="{{$estado->estadoId}}">{{$estado->estadoUf}}</option>@empty<option value="0">Nenhum resultado encontrado!</option>@endforelse</select></div><div class="col-sm-4" id="cidadeNasc">Cidade:<select name="cidade"  id="cidade" class="form-control"></div>'; 
           $('#estadoNasc').remove();
           $('#cidadeNasc').remove();
           $('#estadosCidades').append(inputText);
         }
       }

       function optionCidades(){
          var es = document.getElementById("estado").value;
          url = "{{action('censoController@getCidades')}}";
          $.get(url, {es: es},function (cidades){
           $('select[name=cidade]').empty();
           $('select[name=cidade]').append("<option value='0' disable select style='display:nome;'> Selecione uma cidade</option>");
           $.each(cidades, function (key, value){
             $('select[name=cidade]').append('<option value='+value.cidadeId+'>'+value.cidadeNome+'</option>');
           }); 
         }); 

        }

     </script>
   </div>

</div>
@endsection

