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

    public function impressaoPDF(Request $request){
        $idDadosBase = $request->id;
        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dados Funcionais'),0,1);
        $dadosBase = dadosBase::find($idDadosBase)->get();
        $this->pdf->SetFont('Courier','',12);
        $this->pdf->Cell(130, 5, utf8_decode('Nome: '.$dadosBase[0]->nomeBase),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Matrícula: '.$dadosBase[0]->matriculaBase),0,1);
        $this->pdf->Cell(100, 5, utf8_decode('Cargo: '.$dadosBase[0]->cargoBase),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Data de Admissão: '.$dadosBase[0]->admissaoBase),0,1);
        $this->pdf->Cell(100, 5, utf8_decode('Local de Trab.: '.$dadosBase[0]->localTrabBase),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Secr. deLotação: '.$dadosBase[0]->secretariaBase),0,1);


        $this->pdf->Ln(2);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dados Pessoais'),0,1);
        $this->pdf->Ln(1);
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
        $this->pdf->SetFont('Courier','',12);
        $this->pdf->Cell(120, 5, utf8_decode('Data de Nascimento: '.$dadosPessoais[0]->dataNasc),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Sexo: '.$dadosPessoais[0]->sexo),0,1);
        $this->pdf->Cell(70, 5, utf8_decode('País de Nasc.: '.$dadosPessoais[0]->paisNasc),0,0);
        $this->pdf->Cell(70,5, utf8_decode('Estado: '.$dadosPessoais[0]->estadoNasc),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Cidade: '.$dadosPessoais[0]->cidadeNasc),0,1);
        $this->pdf->Cell(70, 5, utf8_decode('Nome da mãe: '.$dadosPessoais[0]->nomeMae),0,1);
        $this->pdf->Cell(70,5, utf8_decode('Nome do Pai: '.$dadosPessoais[0]->nomePai),0,1);
        $this->pdf->Cell(120, 5, utf8_decode('Estado civil: '.$dadosPessoais[0]->estadoCivil),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Data Casamento: '.$dadosPessoais[0]->dataCasamento),0,1);
        $this->pdf->Cell(70,5, utf8_decode('Nome do Conjugue: '.$dadosPessoais[0]->nomeConjugue),0,1);
        $this->pdf->Cell(120, 5, utf8_decode('Raça/Cor: '.$dadosPessoais[0]->racaCor),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Tipo Sanguinio: '.$dadosPessoais[0]->tipoSanguinio),0,1);
        $this->pdf->Cell(70,5, utf8_decode('Escolaridade: '.$dadosPessoais[0]->escolaridade),0,1);
        $this->pdf->Cell(70,5, utf8_decode('Área de Instrução: '.$dadosPessoais[0]->areaInstrucao),0,1);
        $this->pdf->Cell(120, 5, utf8_decode('Estrangueiro: '.$dadosPessoais[0]->estrangeiro),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Data Chegada ao Brasil: '.$dadosPessoais[0]->dataChegadaBrasil),0,1);
        $this->pdf->Cell(120, 5, utf8_decode('Naturalizado: '.$dadosPessoais[0]->naturalizado),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Data de Naturalização: '.$dadosPessoais[0]->dataNaturalizado),0,1);
        $this->pdf->Cell(120, 5, utf8_decode('Possui algum tipo de deficiência: '.$dadosPessoais[0]->possuiDeficiencia),0,0);
        $this->pdf->Cell(0,5, utf8_decode('Qual? '.$dadosPessoais[0]->qualDeficiencia),0,1);


        $this->pdf->Ln(2);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Documentação'),0,1);
        $this->pdf->Ln(1);
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
        $this->pdf->SetFont('Courier','',12);
        $this->pdf->Cell(120, 5, utf8_decode('CPF: '.$dadosDocumentacao[0]->cpf),0,1);
        $this->pdf->Cell(35, 5, utf8_decode('RG: '.$dadosDocumentacao[0]->rg),0,0);
        $this->pdf->Cell(70,5, utf8_decode('Org. Emissor: '.$dadosDocumentacao[0]->orgaoEmissorRG),0,0);
        $this->pdf->Cell(40,5, utf8_decode('UF: '.$dadosDocumentacao[0]->ufRG),0,0);
        $this->pdf->Cell(55,5, utf8_decode('Data Emissão: '.$dadosDocumentacao[0]->dataEmissaoRG),0,1);
        $this->pdf->Cell(35, 5, utf8_decode('CTPS: '.$dadosDocumentacao[0]->ctps),0,0);
        $this->pdf->Cell(70,5, utf8_decode('Série: '.$dadosDocumentacao[0]->serie),0,0);
        $this->pdf->Cell(40,5, utf8_decode('UF: '.$dadosDocumentacao[0]->ufCtps),0,0);
        $this->pdf->Cell(55,5, utf8_decode('Data Emissão: '.$dadosDocumentacao[0]->dataEmissaoCtps),0,1);
        $this->pdf->Cell(105, 5, utf8_decode('Pis/Pasep: '.$dadosDocumentacao[0]->pisPasep),0,0);
        $this->pdf->Cell(30,5, utf8_decode('Data de cadastramento: '.$dadosDocumentacao[0]->dataCadPisPasep),0,1);

        $this->pdf->Cell(105, 5, utf8_decode('Titulo de Eleitor: '.$dadosDocumentacao[0]->tituloEleitor),0,0);
        $this->pdf->Cell(70,5, utf8_decode('Zona: '.$dadosDocumentacao[0]->zona),0,1);
        $this->pdf->Cell(105,5, utf8_decode('Seção: '.$dadosDocumentacao[0]->secao),0,0);
        $this->pdf->Cell(55,5, utf8_decode('Data Emissão: '.$dadosDocumentacao[0]->dataEmissaoCtps),0,1);
        $this->pdf->Cell(105,5, utf8_decode('Uf votação: '.$dadosDocumentacao[0]->ufVotacao),0,0);
        $this->pdf->Cell(55,5, utf8_decode('Cidade votação: '.$dadosDocumentacao[0]->cidadeVotacao),0,1);
        $this->pdf->Cell(75, 5, utf8_decode('Cert. Militar: '.$dadosDocumentacao[0]->certMilitar),0,0);
        $this->pdf->Cell(50,5, utf8_decode('Situação: '.$dadosDocumentacao[0]->certMilitarSituacao),0,0);
        $this->pdf->Cell(40,5, utf8_decode('Data Emissão: '.$dadosDocumentacao[0]->dataCertMilitar),0,1);
        $this->pdf->Cell(105,5, utf8_decode('Tipo: '.$dadosDocumentacao[0]->tipoCertMilitar),0,0);
        $this->pdf->Cell(55,5, utf8_decode('UF: '.$dadosDocumentacao[0]->ufCertMilitar),0,1);
        $this->pdf->Cell(75,5, utf8_decode('CNH nº: '.$dadosDocumentacao[0]->numCNH),0,0);
        $this->pdf->Cell(55,5, utf8_decode('Registro: '.$dadosDocumentacao[0]->registroCNH),0,0);
        $this->pdf->Cell(80,5, utf8_decode('Data de Emissão: '.$dadosDocumentacao[0]->dataEmissaoCNH),0,1);
        $this->pdf->Cell(75,5, utf8_decode('UF: '.$dadosDocumentacao[0]->ufCNH),0,0);
        $this->pdf->Cell(55,5, utf8_decode('1ª Habil.: '.$dadosDocumentacao[0]->primeiraHabilitacao),0,0);
        $this->pdf->Cell(80,5, utf8_decode('Data de Val.: '.$dadosDocumentacao[0]->dataValidadeCNH),0,1);



        $this->pdf->Output(utf8_decode("TEste.pdf"),"I");
        exit;
    
    }
}
