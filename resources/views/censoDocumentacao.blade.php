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
                          <input class="form-control" name="orgaoEmissor" value="{{old('orgaoEmissor')}}"/>
                        </div>
                        <div class="col-sm-3">
                          UF:
                          <input class="form-control" name="ufRg" value="{{old('ufRg')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissoRg" value="{{old('dataEmissoRg')}}"/>
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
                          <input class="form-control" name="ufCtps" value="{{old('ufCtps')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissoCtps" value="{{old('dataEmissoCtps')}}"/>
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
                          <input class="form-control" name="dataEmissoTituloEleitor" value="{{old('dataEmissoTituloEleitor')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Cidade de Votação:
                          <input class="form-control" name="cidadeVotacao" value="{{old('cidadeVotacao')}}"/>
                        </div>
                        <div class="col-sm-6">
                          UF de Votação:
                          <input class="form-control" name="ufVotacao" value="{{old('ufVotacao')}}"/>
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
                          <input class="form-control" name="datacertMilitar" value="{{old('datacertMilitar')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Tipo:
                          <input class="form-control" name="tipoCertMilitar" value="{{old('tipoCertMilitar')}}"/>
                        </div>
                        <div class="col-sm-6">
                          UF:
                          <input class="form-control" name="ufCertMilitar" value="{{old('ufCertMilitar')}}"/>
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
                          <input class="form-control" name="categoriaCNH" value="{{old('categoriaCNH')}}"/>
                        </div>
                        <div class="col-sm-3">
                          Data emissão:
                          <input class="form-control" name="dataEmissaoCNH" value="{{old('dataEmissaoCNH')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-4">
                          UF:
                          <input class="form-control" name="ufCNH" value="{{old('ufCNH')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Data Validade:
                          <input class="form-control" name="dataValidadeCNH" value="{{old('dataValidadeCNH')}}"/>
                        </div>
                        <div class="col-sm-4">
                          Primeira Habilitação:
                          <input class="form-control" name="primeiraHabilitacao" value="{{old('primeiraHabilitacao')}}"/>
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

                      <div class="row" align="center">
                        <div class="col-sm-12">
                          <a href="dependentes"> Proximo passo</a>
                        </div>
                      </div>

                </div>
            </div>
      </div>
   </div>
</div>
@endsection

