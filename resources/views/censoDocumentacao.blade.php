@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Documentação </h4>
                        <h6>Passo 3 de 4</h6> 
                      </div>

                      <form method="post" action="doc">
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12">
                          CPF: 
                          <input class="form-control" name="cpf" value="{{old('cpf')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          RG:
                          <input class="form-control" name="rg" value="{{old('rg')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Orgão emissor:
                          <input class="form-control" name="orgaoEmissorRG" value="{{old('orgaoEmissorRG')}}"/>
                        </div>
                        <div class="col-sm-3">
                          UF:
                          <select name="ufRg" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissaoRg" value="{{old('dataEmissaoRg')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          Número CTPS:
                          <input class="form-control" name="ctps" value="{{old('ctps')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Serie:
                          <input class="form-control" name="serie" value="{{old('serie')}}"/>
                        </div>
                        <div class="col-sm-3">
                          UF:
                          <select name="ufCtps" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissaoCtps" value="{{old('dataEmissaoCtps')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Pis/PASEP:
                          <input class="form-control" name="pisPasep" value="{{old('pisPasep')}}"/>
                        </div>
                        <div class="col-sm-6">
                          Data de Cadastramento:
                          <input class="form-control" name="dataCadPisPasep" value="{{old('dataCadPisPasep')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          Titulo de Eleitor:
                          <input class="form-control" name="tituloEleitor" value="{{old('tituloEleitor')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Zona:
                          <input class="form-control" name="zona" value="{{old('zona')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Seção:
                          <input class="form-control" name="secao" value="{{old('secao')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissaoTituloEleitor" value="{{old('dataEmissaoTituloEleitor')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          UF de Votação:
                          <select name="ufVotacao" id="ufVotacao" onchange="optionCidades()" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-6">
                          Cidade de Votação:
                          <select name="cidadeVotacao"  id="cidadeVotacao" class="form-control"></select>
                        </div>    
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          Certificado Militar:
                          <input class="form-control" name="certMilitar" value="{{old('certMilitar')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Situação:
                          <input class="form-control" name="certMilitarSituacao" value="{{old('certMilitarSituacao')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Data emissão:
                          <input class="form-control" name="dataCertMilitar" value="{{old('dataCertMilitar')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Tipo de Certificado Militar:
                          <input class="form-control" name="tipoCertMilitar" value="{{old('tipoCertMilitar')}}"/>
                        </div>
                        <div class="col-sm-6">
                          UF do Certificado Militar:
                          <select name="ufCertMilitar" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          Número CNH:
                          <input class="form-control" name="numCNH" value="{{old('numCNH')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Registro:
                          <input class="form-control" name="registroCNH" value="{{old('registroCNH')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Categoria:
                         <select name="categoriaCNH" class="form-control">
                           <option value=""></option>
                           <option value="A">A</option>
                           <option value="B">B</option>
                           <option value="AB">AB</option>
                           <option value="C">C</option>
                           <option value="D">D</option>
                           <option value="E">E</option>
                         </select> 
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissaoCNH" value="{{old('dataEmissaoCNH')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          UF da CNH:
                          <select name="ufCNH" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-4">
                          Data Validade:
                          <input class="form-control" name="dataValidadeCNH" value="{{old('dataValidadeCNH')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Primeira Habilitação:
                          <select name="primeiraHabilitacao" class="form-control">
                           <option value=""></option>
                           <option value="SIM">SIM</option>
                           <option value="NÃO">NÃO</option>
                         </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome do Conselho Profissional:
                          <input class="form-control" name="conselhoProfissional" value="{{old('conselhoProfissional')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          Número Registro:
                          <input class="form-control" name="numConselhoProf" value="{{old('numConselhoProf')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Data emissão:
                          <input class="form-control" name="dataEmissaoConselhoProf" value="{{old('dataEmissaoConselhoProf')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Data validade:
                          <input class="form-control" name="dataValidadeConselhoProf" value="{{old('dataValidadeConselhoProf')}}"/>
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
      <script type="text/javascript">

       function optionCidades(){
          var es = document.getElementById("ufVotacao").value;
          url = "{{action('censoController@getCidades')}}";
          $.get(url, {es: es},function (cidades){
           $('select[name=cidadeVotacao]').empty();
           $('select[name=cidadeVotacao]').append("<option value='0' disable select style='display:nome;'> Selecione uma cidade</option>");
           $.each(cidades, function (key, value){
             $('select[name=cidadeVotacao]').append('<option value='+value.cidadeId+'>'+value.cidadeNome+'</option>');
           }); 
         }); 

        }

     </script>
   </div>
</div>
@endsection

