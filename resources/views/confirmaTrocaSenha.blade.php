@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Confirmação de Troca de Senha</h4>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <a class="navbar-brand" href="{{ url('/') }}">
                            Voltar para página Principal - {{ config('app.name', 'home') }}
                          </a>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          <br/>
                        </div>
                      </div>
            </div>
      </div>
   </div>
</div>
@endsection

