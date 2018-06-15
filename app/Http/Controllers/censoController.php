<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use App\dadosBase;
use App\escolaridade;
use App\pais;
use App\estado;
use App\cidade;

class censoController extends Controller
{
	private $dadosBase;
	private $escolaridade;
	private $pais;
	private $estado;
	private $cidade;

	public function __construct(dadosBase $dadosBase, escolaridade $escolaridade, pais $pais, estado $estado, cidade $cidade){
		$this->dadosBase = $dadosBase;
		$this->escolaridades = $escolaridade;
		$this->paises = $pais;
		$this->estados = $estado;
		$this->cidades = $cidade;
	}

	 public function dadosBase(){ 
	 	$usuario = '1';

	 	$dBasicos = dadosBase::find($usuario);
        return view('welcome', compact('dBasicos'));
    }

    public function getCidades(Request $request, cidade $cidades){
    	$estado = $request->es;
    	//$estado = '1';
    	$cidades = $cidades::where(function($query) use($estado){
    		if($estado)
    			$query->where('estado','=',$estado)->orderBy('cidadeNome');
    	})->get();
    	return response()->json($cidades);
    }

    public function  dadosPessoais(escolaridade $escolaridades, pais $paises, estado $estados){ 
    	$escolaridades = $this->escolaridades->orderBy('id')->get();
    	$paises = $this->paises->orderBy('paisNome')->get();
    	$estados = $this->estados->orderBy('estadoUf')->get();

        return view('censoDadosPessoais', compact('escolaridades','paises', 'estados', 'cidades'));
    }

    public function  enderecoContatos(Request $request){ 
    	
        return view('censoEnderecoContatos');
    }

    public function  documentacao(){ 
        return view('censoDocumentacao');
    }

    public function  dependentes(){ 
        return view('censoDependentes');
    }

    public function  novoDependente(){ 
        return view('censoNovoDependente');
    }

}
