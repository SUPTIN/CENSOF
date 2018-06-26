<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use App\dadosBase;
use App\dadosPessoais;
use App\escolaridade;
use App\pais;
use App\estado;
use App\cidade;

class censoController extends Controller
{
	private $dadosBase;
	private $dadosPessoais;
	private $escolaridade;
	private $pais;
	private $estado;
	private $cidade;


	public function __construct(dadosBase $dadosBase, dadosPessoais $dadosPessoais, escolaridade $escolaridade, pais $pais, estado $estado, cidade $cidade){
		$this->dadosBase = $dadosBase;
		$this->dadosPessoais = $dadosPessoais;
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
    	$cidades = $cidades::where(function($query) use($estado){
    		if($estado)
    			$query->where('estado','=',$estado)->orderBy('cidadeNome');
    	})->get();
    	return response()->json($cidades);
    }

    public function  dadosPessoais(Request $request, escolaridade $escolaridades, pais $paises, estado $estados){ 
    	$escolaridades = $this->escolaridades->orderBy('id')->get();
    	$paises = $this->paises->orderBy('paisNome')->get();
    	$estados = $this->estados->orderBy('estadoUf')->get();
    	$infoBase = dadosBase::find($request->id);
        return view('censoDadosPessoais', compact('escolaridades','paises', 'estados', 'cidades', 'infoBase'));
    }

    public function insereDadosPessoais(Request $request){
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$infoBase = dadosBase::find($idDadosBase)->get();
    	$dados['idDadosBase'] = $idDadosBase;
//return $dados;
    	$infoPessoais = dadosPessoais::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();

    	//return $infoPessoais[0]->idDadosBase;

        if(empty($infoPessoais[0])){
        	$insert = $this->dadosPessoais->create($dados);
    		$novoIdDP = $insert->id;
        }else{
            $infoPessoais->fill($dados)->save();
        	return "opa";
        	
        }
    	

    	if ($dados['nomeBase'] == $infoBase[0]->nomeBase){
    		dadosBase::find($idDadosBase)->update(['dadosPessoais' => '1']);
    	}else{
    		$nomeBase = $dados['nomeBase'];
    		dadosBase::find($idDadosBase)->update(['nomeBase' => $nomeBase, 'dadosPessoais' => '1']);
    	}

    	return '0';
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
