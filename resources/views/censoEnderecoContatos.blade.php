@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Endereço e Contatos </h4>
                        <h6>Passo 2 de 4</h6> 
                      </div>

                      <form method="post" action="eC">
                      <div class="row">
                        <div class="col-sm-6">
                          CEP:
                          <input class="form-control" id="cep" name="cep" value="{{old('cep')}}" onblur="pesquisaCep(this.value);"/>
                        </div>
                        <div class="col-sm-6">
                          Estado:
                          <input class="form-control" id="estadoResidencia" name="estadoResidencia" value="{{old('estadoResidencia')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Cidade:
                          <input class="form-control" id="cidade" name="cidade" value="{{old('cidade')}}"/>
                        </div>
                        <div class="col-sm-6">
                          Bairro:
                          <input class="form-control" id="bairro" name="bairro" value="{{old('bairro')}}"/>
                        </div> 
                      </div>

                      <div class="row">
                        <div class="col-sm-10">
                          Endereço Residencial: 
                          <input class="form-control" id="enderecoResidencial" name="enderecoResidencial" value="{{old('enderecoResidencial')}}"/>
                        </div>
                        <div class="col-sm-2">
                          Número:
                          <input class="form-control" id="numero" name="numero" value="{{old('numero')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Complemento:
                          <input class="form-control" id="complemento" name="complemento" value="{{old('complemento')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          Tel. Residencial:
                          <input class="form-control" name="telResidencial" value="{{old('telResidencial')}}"/>
                        </div>
                        <div class="col-sm-6">
                          Tel. Celular:
                          <input class="form-control" name="telCelular" value="{{old('telCelular')}}"/>
                        </div>
                      </div>

                      <div class="row">
                        
                        <div class="col-sm-12">
                          E-mail:
                          <input class="form-control" name="email" value="{{old('email')}}"/>
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
            document.getElementById('cidade').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('enderecoResidencial').value = ("");
            document.getElementById('estadoResidencia').value = ("");
          }

          function meu_callback(conteudo){
            if(!("erro" in conteudo)){
              document.getElementById('cidade').value = (conteudo.localidade);
              document.getElementById('bairro').value = (conteudo.bairro);
              document.getElementById('enderecoResidencial').value = (conteudo.logradouro);
              document.getElementById('estadoResidencia').value = (conteudo.uf);
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
                document.getElementById('cidade').value = ("...");
                document.getElementById('bairro').value = ("...");
                document.getElementById('enderecoResidencial').value = ("...");
                document.getElementById('estadoResidencia').value = ("...");
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
   
      </script>

   </div>
</div>
@endsection

