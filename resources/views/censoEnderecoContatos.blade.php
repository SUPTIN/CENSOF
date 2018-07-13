@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Endereço e Contatos </h4>
                        <h6>Passo 2 de 5</h6> 
                      </div>

                      <form method="post" action="eC">
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" type="hidden" name="_token" value="{{ csrf_token()}}" />
                        </div>
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
                      <div class="row">
                        <div class="col-sm-12">
                          <label style="font-size:10px;color:red;"> * Campo de preenchimento Obrigatório.</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          CEP: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="cep" name="cep" value="{{old('cep')}}" onblur="pesquisaCep(this.value);"/>
                        </div>
                        <div class="col-sm-6">
                          Estado: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="estadoEC" name="estadoEC" value="{{old('estadoEC')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Cidade: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="cidadeEC" name="cidadeEC" value="{{old('cidadeEC')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                          Bairro: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="bairroEC" name="bairroEC" value="{{old('bairroEC')}}" style="text-transform:uppercase"/>
                        </div> 
                      </div>

                      <div class="row">
                        <div class="col-sm-10">
                          Endereço Residencial: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="enderecoResidencialEC" name="enderecoResidencialEC" value="{{old('enderecoResidencialEC')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-2">
                          Número: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="numeroEC" name="numeroEC" value="{{old('numeroEC')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Complemento:
                          <input class="form-control" id="complementoEC" name="complementoEC" value="{{old('complementoEC')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Tel. Residencial:
                          <input class="form-control" id="telResidencial" name="telResidencial" value="{{old('telResidencial')}}" style="text-transform:uppercase"/>
                        </div>
                        <div class="col-sm-6">
                          Tel. Celular: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" id="telCelular" name="telCelular" value="{{old('telCelular')}}" style="text-transform:uppercase"/>
                        </div>
                      </div>

                      <div class="row">
                        
                        <div class="col-sm-12">
                          E-mail:
                          <input class="form-control" name="email" value="{{old('email')}}" style="text-transform:uppercase"/>
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

          function limpa_cep(){
            document.getElementById('cidadeEC').value = ("");
            document.getElementById('bairroEC').value = ("");
            document.getElementById('enderecoResidencialEC').value = ("");
            document.getElementById('estadoEC').value = ("");
          }

          function meu_callback(conteudo){
            if(!("erro" in conteudo)){
              document.getElementById('cidadeEC').value = (conteudo.localidade);
              document.getElementById('bairroEC').value = (conteudo.bairro);
              document.getElementById('enderecoResidencialEC').value = (conteudo.logradouro);
              document.getElementById('estadoEC').value = (conteudo.uf);
            }else{
              limpa_cep();
              alert("CEP não encontrado!");
            }
          }

          function pesquisaCep(valor){
            var cep = valor.replace(/\D/g, '');
            if(cep != ""){
              var validaCep = /^[0-9]{8}$/;
              if(validaCep.test(cep)){
                document.getElementById('cidadeEC').value = ("...");
                document.getElementById('bairroEC').value = ("...");
                document.getElementById('enderecoResidencialEC').value = ("...");
                document.getElementById('estadoEC').value = ("...");
                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/'+ cep +'/json/?callback=meu_callback';
                document.body.appendChild(script);
              }else{
                limpa_cep();
                alert("Formato de CEP inválido!");
              }
            }else{
              limpa_cep();
            }
          };

          function telResidencial(){
           var $telResidencial = document.getElementById("telResidencial").value;
           if (($telResidencial != '') || ($telResidencial == 'NÃO PREENCHIDO.')){
             var $telResidencial = $("#telResidencial");
             $telResidencial.mask('( 00 ) 0000 0000',{reverse: true});
           }else{
             $('#campoDataChegadaBrasil').hide();
             $telResidencial = 'NÃO PREENCHIDO.'
           }
          }

          function telCelular(){
           var $telCelular = document.getElementById("telCelular").value;
           if (($telCelular != '') || ($telCelular == 'NÃO PREENCHIDO.')){
             var $telCelular = $("#telCelular");
             $telCelular.mask('( 00 ) 0 0000 0000',{reverse: true});
           }else{
             $telCelular = 'NÃO PREENCHIDO.'
           }
          }

          $(document).ready(function(){
            if (($telResidencial != '') || ($telResidencial == 'NÃO PREENCHIDO.')){
              var $telResidencial = $("#telResidencial");
              $telResidencial.mask('( 00 ) 0000 0000',{reverse: true});
            }
            if (($email != '') || ($email != 'NÃO PREENCHIDO.')){
              var $email = $("#email");
              $email.mask("A",{
                 translation:{
                   "A": {pattern: /[\w@\-.+]/,recursive: true}
                 }
              });
            }
            var $telCelular = $("#telCelular");
            $telCelular .mask('( 00 ) 0 0000 0000',{reverse: true});
            telResidencial();
            telCelular();
          });
      </script>

   </div>
</div>
@endsection

