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
use App\enderecoContatos;
use App\documentacao;
use App\dependente;
use App\escolaridade;
use App\pais;
use App\estado;
use App\cidade;

class censoController extends Controller
{
	private $dadosBase;
	private $dadosPessoais;
	private $enderecoContatos;
	private $documentacao;
	private $dependente;
	private $escolaridade;
	private $pais;
	private $estado;
	private $cidade;


	public function __construct(dadosBase $dadosBase, dadosPessoais $dadosPessoais, enderecoContatos $enderecoContatos, documentacao $documentacao, dependente $dependente, escolaridade $escolaridade, pais $pais, estado $estado, cidade $cidade){
		$this->dadosBase = $dadosBase;
		$this->dadosPessoais = $dadosPessoais;
		$this->enderecoContatos = $enderecoContatos;
		$this->documentacao = $documentacao;
		$this->dependente = $dependente;
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

    	$infoPessoais = dadosPessoais::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();	

        if(empty($infoPessoais[0])){
        	$insert = $this->dadosPessoais->create($dados);
    		$novoIdDP = $insert->id;
        }else{
        	dadosPessoais::where('idDadosBase',$idDadosBase)->first()->update($dados);  	
        }
    	
    	if ($dados['nomeBase'] == $infoBase[0]->nomeBase){
    		dadosBase::find($idDadosBase)->update(['dadosPessoais' => '1']);
    	}else{
    		$nomeBase = $dados['nomeBase'];
    		dadosBase::find($idDadosBase)->update(['nomeBase' => $nomeBase, 'dadosPessoais' => '1']);
    	}

    	$caminho = $idDadosBase.'/enderecoContatos';
    	return redirect()->to($caminho);
    	//return view('censoEnderecoContatos', compact('escolaridades','paises', 'estados', 'cidades', 'infoBase'));;
    }

    public function  enderecoContatos(Request $request){ 
        return view('censoEnderecoContatos');
    }

    public function  insereEnderecoContatos(Request $request){ 
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$dados['idDadosBase'] = $idDadosBase;
    	$eC = enderecoContatos::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();	

        if(empty($eC[0])){
        	$insert = $this->enderecoContatos->create($dados);
        }else{
        	enderecoContatos::where('idDadosBase',$idDadosBase)->first()->update($dados);  	
        }
        $caminho = $idDadosBase.'/documentacao';
    	return redirect()->to($caminho);
    }

    public function  documentacao(Request $request, escolaridade $escolaridades, estado $estados){ 
    	$estados = $this->estados->orderBy('estadoUf')->get();
        return view('censoDocumentacao', compact( 'estados', 'cidades'));
    }

    public function  insereDocumentacao(Request $request){ 
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$dados['idDadosBase'] = $idDadosBase;
    	$doc = documentacao::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();	

        if(empty($doc[0])){
        	$insert = $this->documentacao->create($dados);
        }else{
        	documentacao::where('idDadosBase',$idDadosBase)->first()->update($dados);  	
        }
        $caminho = $idDadosBase.'/dependentes';
    	return redirect()->to($caminho);
    }

    public function  dependentes(Request $request){ 
    	$idDadosBase = $request->id;
    	//$dados['idDadosBase'] = $idDadosBase;
    	$dependentes = dependente::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=' , $idDadosBase);
    	})->paginate(5);

    	//return $dependentes;
        return view('censoDependentes', compact('dependentes'));
    }

    public function  novoDependente(){ 
        return view('censoNovoDependente');
    }

    public function  insereDependente(Request $request){ 
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$dados['idDadosBase'] = $idDadosBase;
        $insert = $this->dependente->create($dados);
        
        $caminho = $idDadosBase.'/dependentes';
    	return redirect()->to($caminho);
    }

    public function  impressaoCensoF(Request $request){ 

    	$idDadosBase = $request->id;
    	$dadosBase = dadosBase::find($idDadosBase)->get();

    	$dadosPessoais = dadosPessoais::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();

    	$paisId=$dadosPessoais[0]['paisNasc'];
    	$paisNasc = pais::where(function($query) use($paisId){
    		if($paisId)
    			$query->where('paisId', '=', $paisId);
    	})->get();
    	$dadosPessoais[0]['paisNasc'] = $paisNasc[0]['paisNome']; 

    	if ($paisId == '33'){	
    	  $estadoId=$dadosPessoais[0]['estadoNasc'];
    	  $estadoNasc = estado::where(function($query) use($estadoId){
    		  if($estadoId)
    			  $query->where('estadoId', '=', $estadoId);
    	  })->get();
    	  $dadosPessoais[0]['estadoNasc'] = $estadoNasc[0]['estadoNome']; 

    	  $cidadeId=$dadosPessoais[0]['cidadeNasc'];
    	  $cidadeNasc = cidade::where(function($query) use($cidadeId){
    		  if($cidadeId)
    		  	  $query->where('cidadeId', '=', $cidadeId);
    	  })->get();
    	  $dadosPessoais[0]['cidadeNasc'] = $cidadeNasc[0]['cidadeNome']; 
    	}

    	$escolaridade=$dadosPessoais[0]['escolaridade'];
    	$escolaridade = escolaridade::where(function($query) use($escolaridade){
    		if($escolaridade)
    			$query->where('id', '=', $escolaridade);
    	})->get();
    	$dadosPessoais[0]['escolaridade'] = $escolaridade[0]['descricaoEscolaridade']; 

    	$dadosEndContato = enderecoContatos::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();

    	$dadosDocumentacao = documentacao::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();

    	$ufRGId=$dadosDocumentacao[0]['ufRG'];
    	$ufRG = estado::where(function($query) use($ufRGId){
    		if($ufRGId)
    			$query->where('estadoId', '=', $ufRGId);
    	})->get();
    	$dadosDocumentacao[0]['ufRG'] = $ufRG[0]['estadoNome']; 

    	$ufCtpsId=$dadosDocumentacao[0]['ufCtps'];
    	$ufCtps= estado::where(function($query) use($ufCtpsId){
    		if($ufCtpsId)
    			$query->where('estadoId', '=', $ufCtpsId);
    	})->get();
    	$dadosDocumentacao[0]['ufCtps'] = $ufCtps[0]['estadoNome']; 

    	$ufVotacaoId=$dadosDocumentacao[0]['ufVotacao'];
    	$ufVotacao= estado::where(function($query) use($ufVotacaoId){
    		if($ufVotacaoId)
    			$query->where('estadoId', '=', $ufVotacaoId);
    	})->get();
    	$dadosDocumentacao[0]['ufVotacao'] = $ufVotacao[0]['estadoNome'];
    	$cidadeVotacaoId=$dadosDocumentacao[0]['cidadeVotacao'];
    	$cidadeVotacao = cidade::where(function($query) use($cidadeVotacaoId){
    		if($cidadeVotacaoId)
    		  	$query->where('cidadeId', '=', $cidadeVotacaoId);
    	})->get();
    	$dadosDocumentacao[0]['cidadeVotacao'] = $cidadeVotacao[0]['cidadeNome']; 

        $ufCertMilitarId=$dadosDocumentacao[0]['ufCertMilitar'];
    	$ufCertMilitar= estado::where(function($query) use($ufCertMilitarId){
    		if($ufCertMilitarId)
    			$query->where('estadoId', '=', $ufCertMilitarId);
    	})->get();
    	$dadosDocumentacao[0]['ufCertMilitar'] = $ufCertMilitar[0]['estadoNome'];
    	$ufCNHId=$dadosDocumentacao[0]['ufCNH'];
    	$ufCNH= estado::where(function($query) use($ufCNHId){
    		if($ufCNHId)
    			$query->where('estadoId', '=', $ufCNHId);
    	})->get();
    	$dadosDocumentacao[0]['ufCNH'] = $ufCNH[0]['estadoNome'];

    	$dadosDependente = dependente::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=' , $idDadosBase);
    	})->get();

    	return view('censoImpressaoFichas', compact('dadosBase', 'dadosPessoais', 'dadosEndContato', 'dadosDocumentacao', 'dadosDependente'));
    }
}
