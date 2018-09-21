<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use App\User;

use App\dadosBase;
use App\dadosPessoais;
use App\enderecoContatos;
use App\documentacao;
use App\dependente;
use App\escolaridade;
use App\pais;
use App\estado;
use App\cidade;
use App\arquivos;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('insere_dadosBase', function(User $user, dadosBase $dadosBase){
            return $user->matricula == $dadosBase->matriculaBase;
        });

        $gate->define('insere_enderecoContatos', function(User $user, enderecoContatos $eC){
            return $user->id == $eC->idDadosBase;
        });
        
        $gate->define('insere_documentacao', function(User $user, documentacao $doc){
            return $user->id == $doc->idDadosBase;
        });

        $gate->define('insere_dependente', function(User $user, dependente $dependentes){
            return $user->id == $dependentes->idDadosBase;
        });

        $gate->define('edit_dependente', function(User $user, dependente $dependentes){
            return $user->id == $dependentes->idDadosBase;
        });

        $gate->define('insere_arquivos', function(User $user, arquivos $arquivos){
            return $user->id == $arquivos->idDadosBase;
        });

        $gate->define('view_arquivos', function(User $user, arquivos $arquivos){
            return $user->id == $arquivos->idDadosBase;
        });

        $gate->define('ficha', function(User $user, dadosPessoais $dadosPessoais){
            return $user->id == $dadosPessoais->idDadosBase;
        });

    }
}
