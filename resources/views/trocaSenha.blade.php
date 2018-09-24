@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Troca Senha</h4>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <label style="font-size:10px;color:red;"> * Os campos são obrigatórios</label>
                        </div>
                      </div>

                      <form method="post" action="updateSenha">
                      <div class="row">
                        <div class="col-sm-12">
                          <input class="form-control" type="hidden" name="_token" value="{{ csrf_token()}}"/>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          Nova Senha: <label style="font-size:15px;color:red;">*</label>
                          <input class="form-control" type="password" name="password"/>
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
@endsection

