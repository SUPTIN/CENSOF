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

    protected $pdf;


	public function __construct(dadosBase $dadosBase, dadosPessoais $dadosPessoais, enderecoContatos $enderecoContatos, documentacao $documentacao, dependente $dependente, escolaridade $escolaridade, pais $pais, estado $estado, cidade $cidade, \App\Pdf $pdf){
		$this->dadosBase = $dadosBase;
		$this->dadosPessoais = $dadosPessoais;
		$this->enderecoContatos = $enderecoContatos;
		$this->documentacao = $documentacao;
		$this->dependente = $dependente;
		$this->escolaridades = $escolaridade;
		$this->paises = $pais;
		$this->estados = $estado;
		$this->cidades = $cidade;

        $this->pdf = $pdf;
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
        $idDadosBase= $request->id;

        $infoPessoais = dadosPessoais::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();
        if(empty($infoPessoais[0])){
             return view('censoDadosPessoais', compact('escolaridades','paises', 'estados', 'cidades', 'infoBase'));
        }else{
            $infoPessoais = $infoPessoais[0];    
            return view('censoDadosPessoaisUpdate', compact('escolaridades','paises', 'estados', 'cidades', 'infoBase','infoPessoais')); 
        }

        
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

        if ($request->estadoCivil != "CASADO"){
                $dados['dataCasamento'] = 'NÃO NECESSÁRIO.';
            }
        if ($request->nomeConjugue == ""){
                $dados['nomeConjugue'] = 'NÃO NECESSÁRIO.';
            }
        if ($request->estrangeiro == "NÃO"){
                $dados['dataChegadaBrasil'] = 'NÃO NECESSÁRIO.';
            }
        if ($request->naturalizado == "NÃO"){
                $dados['dataNaturalizado'] = 'NÃO NECESSÁRIO.';
            }
        if ($request->possuiDeficiencia == "NÃO"){
                $dados['qualDeficiencia'] = 'NÃO NECESSÁRIO.';
            }
        $this->validate($request, $this->dadosPessoais->rules, $this->dadosPessoais->messages);
        $this->validate($request, $this->dadosBase->rules, $this->dadosBase->messages);

        if(empty($infoPessoais[0])){
        	$insert = $this->dadosPessoais->create($dados);
    		$novoIdDP = $insert->id;
        }else{
        	dadosPessoais::where('idDadosBase',$idDadosBase)->first()->update($dados);  	
        }

        $nomeBase = $dados['nomeBase'];
        $secretariaBase = $dados['secretariaBase'];
        $localTrabBase = $dados['localTrabBase'];
        dadosBase::find($idDadosBase)->update(['dadosPessoais' => '1', 'localTrabBase' => $localTrabBase, 'secretariaBase' => $secretariaBase,'nomeBase' => $nomeBase]);

    	$caminho = $idDadosBase.'/enderecoContatos';
    	return redirect()->to($caminho);
    }

    public function  enderecoContatos(Request $request){ 
        $idDadosBase = $request->id;

        $eC = enderecoContatos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();

        if (empty($eC[0])){
            //return 'vazio';
            return view('censoEnderecoContatos');
        }else{
            $eC = $eC[0];
            return view('censoEnderecoContatosUpdate',compact('eC'));
        }
    }

    public function  insereEnderecoContatos(Request $request){ 
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$dados['idDadosBase'] = $idDadosBase;
    	$eC = enderecoContatos::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();

        if (($request->complementoEC == "") || ($request->complementoEC == "NÃO PREENCHIDO.")){
                $dados['complementoEC'] = 'NÃO PREENCHIDO.';
            }
        if (($request->telResidencial == "")||($request->telResidencial == "NÃO PREENCHIDO.")){
                $dados['telResidencial'] = 'NÃO PREENCHIDO.';
            }
        if (($request->email == "")||($request->email == "NÃO PREENCHIDO.")){
                $dados['email'] = 'NÃO PREENCHIDO.';
            }
        $this->validate($request, $this->enderecoContatos->rules, $this->enderecoContatos->messages);
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
        $idDadosBase = $request->id;
        $doc = documentacao::where(function($query) use($idDadosBase){
           if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();

        if (empty($doc[0])){
            return view('censoDocumentacao', compact( 'estados', 'cidades'));
        }else{
            $doc = $doc[0];
            return view('censoDocumentacaoUpdate', compact( 'estados', 'cidades','doc'));
        }
        
    }

    public function  insereDocumentacao(Request $request){ 
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$dados['idDadosBase'] = $idDadosBase;
    	$doc = documentacao::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=', $idDadosBase);
    	})->get();	

        if (($request->certMilitar == "") || ($request->certMilitar == "NÃO PREENCHIDO.")){
                $dados['certMilitar'] = 'NÃO PREENCHIDO.';
        }
        if (($request->certMilitarSituacao == "") || ($request->certMilitarSituacao == "NÃO PREENCHIDO.")){
                $dados['certMilitarSituacao'] = 'NÃO PREENCHIDO.';
        }
        if (($request->dataCertMilitar == "") || ($request->dataCertMilitar == "NÃO PREENCHIDO.")){
                $dados['dataCertMilitar'] = 'NÃO PREENCHIDO.';
        }
        if (($request->tipoCertMilitar == "") || ($request->tipoCertMilitar == "NÃO PREENCHIDO.")){
                $dados['tipoCertMilitar'] = 'NÃO PREENCHIDO.';
        }
        if (($request->ufCertMilitar == "") || ($request->ufCertMilitar == "NÃO PREENCHIDO.")){
                $dados['ufCertMilitar'] = 'NÃO PREENCHIDO.';
        }
        if (($request->numCNH == "") || ($request->numCNH == "NÃO PREENCHIDO.")){
                $dados['numCNH'] = 'NÃO PREENCHIDO.';
        }
        if (($request->registroCNH == "") || ($request->registroCNH == "NÃO PREENCHIDO.")){
                $dados['registroCNH'] = 'NÃO PREENCHIDO.';
        }
        if (($request->categoriaCNH == "") || ($request->Categoria == "NÃO PREENCHIDO.")){
                $dados['categoriaCNH'] = 'NÃO PREENCHIDO.';
        }
        if (($request->dataEmissaoCNH == "") || ($request->dataEmissaoCNH == "NÃO PREENCHIDO.")){
                $dados['dataEmissaoCNH'] = 'NÃO PREENCHIDO.';
        }
        if (($request->ufCNH == "") || ($request->ufCNH == "NÃO PREENCHIDO.")){
                $dados['ufCNH'] = 'NÃO PREENCHIDO.';
        }
        if (($request->dataValidadeCNH == "") || ($request->dataValidadeCNH == "NÃO PREENCHIDO.")){
                $dados['dataValidadeCNH'] = 'NÃO PREENCHIDO.';
        }
        if (($request->primeiraHabilitacao == "") || ($request->primeiraHabilitacao == "NÃO PREENCHIDO.")){
                $dados['primeiraHabilitacao'] = 'NÃO PREENCHIDO.';
        }
        if (($request->conselhoProfissional == "") || ($request->conselhoProfissional == "NÃO PREENCHIDO.")){
                $dados['conselhoProfissional'] = 'NÃO PREENCHIDO.';
        }
        if (($request->numConselhoProf == "") || ($request->numConselhoProf == "NÃO PREENCHIDO.")){
                $dados['numConselhoProf'] = 'NÃO PREENCHIDO.';
        }
        if (($request->dataEmissaoConselhoProf == "") || ($request->dataEmissaoConselhoProf == "NÃO PREENCHIDO.")){
                $dados['dataEmissaoConselhoProf'] = 'NÃO PREENCHIDO.';
        }
        if (($request->dataValidadeConselhoProf == "") || ($request->dataValidadeConselhoProf == "NÃO PREENCHIDO.")){
                $dados['dataValidadeConselhoProf'] = 'NÃO PREENCHIDO.';
        }
        if ($request->cidadeVotacao == "0"){
                $dados['cidadeVotacao'] = '';
        }

        $this->validate($request, $this->documentacao->rules, $this->documentacao->messages);

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
    	$dependentes = dependente::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=' , $idDadosBase);
    	})->paginate(5);

        return view('censoDependentes', compact('dependentes'));
    }

    public function  novoDependente(){ 
        return view('censoNovoDependente');
    }

    public function  insereDependente(Request $request){ 
    	$dados = $request->all();
    	$idDadosBase = $request->id;
    	$dados['idDadosBase'] = $idDadosBase;
        $this->validate($request, $this->dependente->rules, $this->dependente->messages);

        $insert = $this->dependente->create($dados);
        
        $caminho = $idDadosBase.'/dependentes';
    	return redirect()->to($caminho);
    }

    public function editDependente(Request $request){ 
        $dados = $request->all();
        $idDependente = $request->id;
        $dados['idDependente'] = $idDependente;
        $dependente = dependente::where(function($query) use($idDependente ){
            if($idDependente)
                $query->where('idDependente', '=' , $idDependente );
        })->get();

        return view('censoEditDependenteUpdate',compact('dependente'));
    }

    public function updateDep(Request $request){ 
        $dados = $request->all();
        $idDependente = $request->id;
        $dados['idDependente'] = $idDependente;
        $dependente = dependente::where(function($query) use($idDependente ){
            if($idDependente)
                $query->where('idDependente', '=' , $idDependente );
        })->get();

        dependente::where('idDependente',$idDependente)->first()->update($dados); 
        return redirect()->to($dependente[0]->idDadosBase.'/dependentes');
    }

    public function delDependente(Request $request){ 
        $idDependente = $request->id;
        $dependente = dependente::where(function($query) use($idDependente ){
            if($idDependente)
                $query->where('idDependente', '=' , $idDependente );
        })->get();
        dependente::where('idDependente',$idDependente)->delete(); 
        return redirect()->to($dependente[0]->idDadosBase.'/dependentes');  
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
        if ($dadosDocumentacao[0]['ufCertMilitar'] != 'NÃO PREENCHIDO.'){
    	  $dadosDocumentacao[0]['ufCertMilitar'] = $ufCertMilitar[0]['estadoNome'];
        }
        
        $ufCNHId=$dadosDocumentacao[0]['ufCNH'];
    	$ufCNH= estado::where(function($query) use($ufCNHId){
    		if($ufCNHId)
    			$query->where('estadoId', '=', $ufCNHId);
    	})->get();
        if ($dadosDocumentacao[0]['ufCNH'] != 'NÃO PREENCHIDO.'){
    	   $dadosDocumentacao[0]['ufCNH'] = $ufCNH[0]['estadoNome'];
        }

    	$dadosDependente = dependente::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=' , $idDadosBase);
    	})->get();

    	return view('censoImpressaoFichas', compact('dadosBase', 'dadosPessoais', 'dadosEndContato', 'dadosDocumentacao', 'dadosDependente'));
    }

    public function impressaoPDF(Request $request){
        $idDadosBase = $request->id;
        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dados Funcionais'),0,1);
        $dadosBase = dadosBase::find($idDadosBase)->get();
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(13,5, utf8_decode('Nome: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120, 5, utf8_decode(strtoupper($dadosBase[0]->nomeBase)),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(26,5, utf8_decode('Matrícula: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode(strtoupper($dadosBase[0]->matriculaBase)),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(16,5, utf8_decode('Cargo: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(100, 5, utf8_decode(strtoupper($dadosBase[0]->cargoBase)),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(44,5, utf8_decode('Data de Admissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode(strtoupper($dadosBase[0]->admissaoBase)),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(39,5, utf8_decode('Local de Trab.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(77, 5, utf8_decode(strtoupper($dadosBase[0]->localTrabBase)),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Sec. Lotação: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, strtoupper(utf8_decode($dadosBase[0]->secretariaBase)),0,1);


        $this->pdf->Ln(7);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dados Pessoais'),0,1);
        $this->pdf->Ln(2);
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
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(36,5, utf8_decode('Data de Nasc.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(83, 5, utf8_decode($dadosPessoais[0]->dataNasc),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(14,5, utf8_decode('Sexo: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->sexo),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(40,5, utf8_decode('País de Nasc.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70, 5, utf8_decode($dadosPessoais[0]->paisNasc),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(20,5, utf8_decode('Estado: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(98,5, utf8_decode($dadosPessoais[0]->estadoNasc),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(20,5, utf8_decode('Cidade: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->cidadeNasc),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(32,5, utf8_decode('Nome da mãe: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70, 5, utf8_decode($dadosPessoais[0]->nomeMae),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(32,5, utf8_decode('Nome do Pai: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70,5, utf8_decode($dadosPessoais[0]->nomePai),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Estado civil: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(84, 5, utf8_decode($dadosPessoais[0]->estadoCivil),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(40,5, utf8_decode('Data Casamento: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->dataCasamento),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(45,5, utf8_decode('Nome do Conjugue: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70,5, utf8_decode($dadosPessoais[0]->nomeConjugue),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(25,5, utf8_decode('Raça/Cor: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(93, 5, utf8_decode($dadosPessoais[0]->racaCor),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(40,5, utf8_decode('Tipo Sanguinio: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->tipoSanguinio),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Escolaridade: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->MultiCell(160,6, utf8_decode($dadosPessoais[0]->escolaridade),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(46,5, utf8_decode('Área de Instrução: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70,5, utf8_decode($dadosPessoais[0]->areaInstrucao),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(36,5, utf8_decode('Estrangueiro: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($dadosPessoais[0]->estrangeiro),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(59,5, utf8_decode('Data Chegada ao Brasil: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->dataChegadaBrasil),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(36,5, utf8_decode('Naturalizado: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($dadosPessoais[0]->naturalizado),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(58,5, utf8_decode('Data de Naturalização: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->dataNaturalizado),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(85,5, utf8_decode('Possui algum tipo de deficiência: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120, 5, utf8_decode($dadosPessoais[0]->possuiDeficiencia),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Qual? '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, utf8_decode($dadosPessoais[0]->qualDeficiencia),0,1);


        $this->pdf->Ln(5);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Documentação'),0,1);
        $this->pdf->Ln(2);
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
        if ($dadosDocumentacao[0]['ufCertMilitar'] != 'NÃO PREENCHIDO.'){
          $dadosDocumentacao[0]['ufCertMilitar'] = $ufCertMilitar[0]['estadoNome'];
        }
        $ufCNHId=$dadosDocumentacao[0]['ufCNH'];
        $ufCNH= estado::where(function($query) use($ufCNHId){
            if($ufCNHId)
                $query->where('estadoId', '=', $ufCNHId);
        })->get();
        if ($dadosDocumentacao[0]['ufCNH'] != 'NÃO PREENCHIDO.'){
           $dadosDocumentacao[0]['ufCNH'] = $ufCNH[0]['estadoNome'];
        }

        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(11,5, utf8_decode('CPF: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120, 5, utf8_decode($dadosDocumentacao[0]->cpf),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(10,5, utf8_decode('RG: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70, 5, utf8_decode($dadosDocumentacao[0]->rg),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Org. Emissor: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(30,5, utf8_decode($dadosDocumentacao[0]->orgaoEmissorRG),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(10,5, utf8_decode('UF: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70,5, utf8_decode($dadosDocumentacao[0]->ufRG),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Data Emissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(55,5, utf8_decode($dadosDocumentacao[0]->dataEmissaoRG),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('CTPS: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(65, 5, utf8_decode($dadosDocumentacao[0]->ctps),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Série: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(50,5, utf8_decode($dadosDocumentacao[0]->serie),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(10,5, utf8_decode('UF: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70,5, utf8_decode($dadosDocumentacao[0]->ufCtps),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Data Emissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(55,5, utf8_decode($dadosDocumentacao[0]->dataEmissaoCtps),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(25,5, utf8_decode('Pis/Pasep: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(80, 5, utf8_decode($dadosDocumentacao[0]->pisPasep),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(56,5, utf8_decode('Data de cadastramento: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(30,5, utf8_decode($dadosDocumentacao[0]->dataCadPisPasep),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(46,5, utf8_decode('Titulo de Eleitor: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(59, 5, utf8_decode($dadosDocumentacao[0]->tituloEleitor),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Zona: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(70,5, utf8_decode($dadosDocumentacao[0]->zona),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Seção: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(90,5, utf8_decode($dadosDocumentacao[0]->secao),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Data Emissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(55,5, utf8_decode($dadosDocumentacao[0]->dataEmissaoCtps),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(30,5, utf8_decode('Uf votação: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(75,5, utf8_decode($dadosDocumentacao[0]->ufVotacao),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(40,5, utf8_decode('Cidade votação: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(55,5, utf8_decode($dadosDocumentacao[0]->cidadeVotacao),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(36,5, utf8_decode('Cert. Militar: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(40, 5, utf8_decode($dadosDocumentacao[0]->certMilitar),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(25,5, utf8_decode('Situação: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(30,5, utf8_decode($dadosDocumentacao[0]->certMilitarSituacao),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Data Emissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(40,5, utf8_decode($dadosDocumentacao[0]->dataCertMilitar),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Tipo: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(90,5, utf8_decode($dadosDocumentacao[0]->tipoCertMilitar),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(10,5, utf8_decode('UF: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(55,5, utf8_decode($dadosDocumentacao[0]->ufCertMilitar),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(20,5, utf8_decode('CNH nº: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(56,5, utf8_decode($dadosDocumentacao[0]->numCNH),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(23,5, utf8_decode('Registro: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(40,5, utf8_decode($dadosDocumentacao[0]->registroCNH),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Data Emissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(80,5, utf8_decode($dadosDocumentacao[0]->dataEmissaoCNH),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(8,5, utf8_decode('UF: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(68,5, utf8_decode($dadosDocumentacao[0]->ufCNH),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(27,5, utf8_decode('Categoria: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(30,5, utf8_decode($dadosDocumentacao[0]->categoriaCNH),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(27,5, utf8_decode('1ª Habil.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(27,5, utf8_decode($dadosDocumentacao[0]->primeiraHabilitacao),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Data de Val.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(80,5, utf8_decode($dadosDocumentacao[0]->dataValidadeCNH),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(57,5, utf8_decode('Conselho Profissional: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120,5, utf8_decode($dadosDocumentacao[0]->conselhoProfissional),0,1);
        $this->pdf->SetFont('Courier','B',12);
        $this->pdf->Cell(31,5, utf8_decode('Nº Registro: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(45,5, utf8_decode($dadosDocumentacao[0]->numConselhoProf),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(32,5, utf8_decode('Data Emissão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(30,5, utf8_decode($dadosDocumentacao[0]->dataEmissaoConselhoProf),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Data de Val.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(80,5, utf8_decode($dadosDocumentacao[0]->dataValidadeConselhoProf),0,1);

        $this->pdf->Ln(5);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dependentes'),0,1);
        $this->pdf->Ln(2);
        $dadosDependente = dependente::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->get();
        $itens = $dadosDependente->count();
        $this->pdf->SetFont('Courier','',11);
        if ($itens > 0 ){
            for($i=0; $i < $itens; $i++){
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(13,5, utf8_decode('Nome: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(120,5, utf8_decode($dadosDependente[$i]->nomeDependente),0,1); 
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(31,5, utf8_decode('CPF Depend.: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(64,5, utf8_decode($dadosDependente[$i]->cpfDependente),0,0);
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(29,5, utf8_decode('Data Nasc.: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(61,5, utf8_decode($dadosDependente[$i]->dataNascDependente),0,1);
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(15,5, utf8_decode('Sexo: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(80,5, utf8_decode($dadosDependente[$i]->sexoDependente),0,0);
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(35,5, utf8_decode('Estado cívil: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(80,5, utf8_decode($dadosDependente[$i]->estadoCivilDependente),0,1);
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(29,5, utf8_decode('Parentesco: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(61,5, utf8_decode($dadosDependente[$i]->nomeDependente),0,1);
                 $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(60,5, utf8_decode('Dep. para Dedução IRPF: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(35,5, utf8_decode($dadosDependente[$i]->deducaoImposto),0,0);
                $this->pdf->SetFont('Courier','B',11);
                $this->pdf->Cell(68,5, utf8_decode('Dep. para Salário Família: '),0,0);
                $this->pdf->SetFont('Courier','',11);
                $this->pdf->Cell(60,5, utf8_decode($dadosDependente[$i]->salarioFamilia),0,1);
                $this->pdf->Ln(2);
            }
        }else{
            $this->pdf->SetFont('Courier','B',11);
            $this->pdf->Cell(80,5, utf8_decode('NÃO EXISTE DEPENDENTE CADASTRADO!'),0,1);
        }


        $this->pdf->Output(utf8_decode("TEste.pdf"),"D");
        exit;
    
    }
}
