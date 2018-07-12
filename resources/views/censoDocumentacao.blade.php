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
                          CPF: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="cpf" name="cpf" value="{{old('cpf')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          RG: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="rg" value="{{old('rg')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Orgão emissor: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="orgaoEmissorRG" value="{{old('orgaoEmissorRG')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          UF: <label style="font-size:15px;color:red;">*</label>
                          <select name="ufRG" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option {{ old('ufRG') == $estado->estadoId ? 'selected' : '' }} value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-3">
                          Data emissão: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="dataEmissaoRG" name="dataEmissaoRG" value="{{old('dataEmissaoRG')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          Número CTPS: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="ctps" value="{{old('ctps')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Serie: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="serie" name="serie" value="{{old('serie')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          UF: <label style="font-size:15px;color:red;">*</label>
                          <select name="ufCtps" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option {{ old('ufCtps') == $estado->estadoId ? 'selected' : '' }} value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-3">
                          Data emissão: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="dataEmissaoCtps" name="dataEmissaoCtps" value="{{old('dataEmissaoCtps')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Pis/PASEP: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="pisPasep" name="pisPasep" value="{{old('pisPasep')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                          Data de Cadastramento: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="dataCadPisPasep" name="dataCadPisPasep" value="{{old('dataCadPisPasep')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          Titulo de Eleitor: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="tituloEleitor" value="{{old('tituloEleitor')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Zona: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="zona" value="{{old('zona')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Seção: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" name="secao" value="{{old('secao')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Data emissão: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="dataEmissaoTituloEleitor" name="dataEmissaoTituloEleitor" value="{{old('dataEmissaoTituloEleitor')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          UF de Votação: <label style="font-size:15px;color:red;">*</label>
                          <select name="ufVotacao" id="ufVotacao" onchange="optionCidades()" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option {{ old('ufVotacao') == $estado->estadoId ? 'selected' : '' }} value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-6">
                          Cidade de Votação: <label style="font-size:15px;color:red;">*</label>
                          <select name="cidadeVotacao"  id="cidadeVotacao" class="form-control"></select>
                        </div>    
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          Certificado Militar: 
                          <input class="form-control" name="certMilitar" value="{{old('certMilitar')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-4">
                          Situação:
                          <input class="form-control" name="certMilitarSituacao" value="{{old('certMilitarSituacao')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-4">
                          Data emissão:
                          <input class="form-control" id="dataCertMilitar" name="dataCertMilitar" value="{{old('dataCertMilitar')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Tipo de Certificado Militar:
                          <input class="form-control" name="tipoCertMilitar" value="{{old('tipoCertMilitar')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                          UF do Certificado Militar:
                          <select name="ufCertMilitar" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option {{ old('ufCertMilitar') == $estado->estadoId ? 'selected' : '' }}  value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-3">
                          Número CNH:
                          <input class="form-control" name="numCNH" value="{{old('numCNH')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Registro:
                          <input class="form-control" name="registroCNH" value="{{old('registroCNH')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-3">
                          Categoria:
                         <select name="categoriaCNH" class="form-control">
                           <option value=""></option>
                           <option {{ old('categoriaCNH') == 'A' ? 'selected' : '' }} value="A">A</option>
                           <option {{ old('categoriaCNH') == 'B' ? 'selected' : '' }} value="B">B</option>
                           <option {{ old('categoriaCNH') == 'AB' ? 'selected' : '' }} value="AB">AB</option>
                           <option {{ old('categoriaCNH') == 'C' ? 'selected' : '' }} value="C">C</option>
                           <option {{ old('categoriaCNH') == 'D' ? 'selected' : '' }} value="D">D</option>
                           <option {{ old('categoriaCNH') == 'E' ? 'selected' : '' }} value="E">E</option>
                         </select> 
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" id="dataEmissaoCNH" name="dataEmissaoCNH" value="{{old('dataEmissaoCNH')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          UF da CNH:
                          <select name="ufCNH" class="form-control">
                            <option value=""></option>
                            @forelse($estados as $estado)
                              <option {{ old('ufCNH') == $estado->estadoId ? 'selected' : '' }} value="{{$estado->estadoId}}">{{$estado->estadoNome}}</option>
                            @empty
                              <option value="0">Nenhum resultado encontrado!</option>
                            @endforelse
                          </select>
                        </div>
                        <div class="col-sm-4">
                          Data Validade:
                          <input class="form-control" id="dataValidadeCNH" name="dataValidadeCNH" value="{{old('dataValidadeCNH')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-4">
                          Reg. 1ª Habilitação:
                           <input class="form-control" name="primeiraHabilitacao" value="{{old('primeiraHabilitacao')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nome do Conselho Profissional:
                          <input class="form-control" name="conselhoProfissional" value="{{old('conselhoProfissional')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          Número Registro:
                          <input class="form-control" name="numConselhoProf" value="{{old('numConselhoProf')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-4">
                          Data emissão:
                          <input class="form-control" id="dataEmissaoConselhoProf" name="dataEmissaoConselhoProf" value="{{old('dataEmissaoConselhoProf')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-4">
                          Data validade:
                          <input class="form-control" id="dataValidadeConselhoProf" name="dataValidadeConselhoProf" value="{{old('dataValidadeConselhoProf')}}" style="text-transform:uppercase"/>
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
           $('select[name=cidadeVotacao]').append("<option value='' disable select style='display:nome;'> Selecione uma cidade</option>");
           $.each(cidades, function (key, value){
             $('select[name=cidadeVotacao]').append('<option value='+value.cidadeId+'>'+value.cidadeNome+'</option>');
           }); 
         }); 
        }

        $(document).ready(function(){

         var $cpf = $("#cpf");
         $cpf.mask('000.000.000-00',{reverse: true});

         //var $pisPasep = $("#pisPasep");
         //$pisPasep.mask('000.00000.00-0',{reverse: true});

         var $dataEmissaoRg = $("#dataEmissaoRG");
         $dataEmissaoRg.mask('00/00/0000',{reverse: true});

         var $dataEmissaoCtps = $("#dataEmissaoCtps");
         $dataEmissaoCtps.mask('00/00/0000',{reverse: true});

         var $dataCadPisPasep = $("#dataCadPisPasep");
         $dataCadPisPasep.mask('00/00/0000',{reverse: true});

         var $dataEmissaoTituloEleitor = $("#dataEmissaoTituloEleitor");
         $dataEmissaoTituloEleitor.mask('00/00/0000',{reverse: true});

         var $dataCertMilitar = $("#dataCertMilitar");
         $dataCertMilitar.mask('00/00/0000',{reverse: true});

         var $dataEmissaoCNH = $("#dataEmissaoCNH");
         $dataEmissaoCNH.mask('00/00/0000',{reverse: true});

         var $dataValidadeCNH = $("#dataValidadeCNH");
         $dataValidadeCNH.mask('00/00/0000',{reverse: true});

         var $dataEmissaoConselhoProf = $("#dataEmissaoConselhoProf");
         $dataEmissaoConselhoProf.mask('00/00/0000',{reverse: true});

         var $dataValidadeConselhoProf = $("#dataValidadeConselhoProf");
         $dataValidadeConselhoProf.mask('00/00/0000',{reverse: true});

         optionCidades();

        });

     </script>
   </div>
</div>
@endsection

