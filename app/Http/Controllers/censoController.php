<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Gate;
use app\User;

use Session;
use App\dadosBase;
use App\dadosPessoais;
use App\enderecoContatos;
use App\documentacao;
use App\vinculoEmpregaticio;
use App\dependente;
use App\escolaridade;
use App\pais;
use App\estado;
use App\cidade;
use App\arquivos;

class censoController extends Controller
{
	private $dadosBase;
	private $dadosPessoais;
	private $enderecoContatos;
	private $documentacao;
    private $vinculoEmpregaticio;
	private $dependente;
	private $escolaridade;
	private $pais;
	private $estado;
	private $cidade;
    private $arquivos;

    protected $pdf;


	public function __construct(dadosBase $dadosBase, dadosPessoais $dadosPessoais, enderecoContatos $enderecoContatos, documentacao $documentacao, vinculoEmpregaticio $vinculoEmpregaticio, dependente $dependente, escolaridade $escolaridade, pais $pais, estado $estado, cidade $cidade, \App\Pdf $pdf, arquivos $arquivos){
		$this->dadosBase = $dadosBase;
		$this->dadosPessoais = $dadosPessoais;
		$this->enderecoContatos = $enderecoContatos;
		$this->documentacao = $documentacao;
        $this->vinculoEmpregaticio = $vinculoEmpregaticio;
		$this->dependente = $dependente;
		$this->escolaridades = $escolaridade;
		$this->paises = $pais;
		$this->estados = $estado;
		$this->cidades = $cidade;
        $this->arquivos = $arquivos;

        $this->pdf = $pdf;

        $this->middleware('auth');
	}

    public function semPermissao(){ 
        return view('semPermissao');
    }

	public function dadosBase(){ 

	 	$usuario = Auth::user()->matricula;

	 	$dBasicos = dadosBase::where(function($query) use($usuario){
            if($usuario)
                $query->where('matriculaBase', '=', $usuario);
        })->get();


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

        if (Gate::denies('insere_dadosBase', $infoBase)){
            //abort(403, 'Não Autorizado');
            return view('semPermissao');
        }

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
                $dados['dataCasamento'] = ' ';
            }
        if ($request->nomeConjugue == ""){
                $dados['nomeConjugue'] = ' ';
            }
        if ($request->estrangeiro == "NÃO"){
                $dados['dataChegadaBrasil'] = ' ';
            }
        if ($request->naturalizado == "NÃO"){
                $dados['dataNaturalizado'] = ' ';
            }
        if ($request->possuiDeficiencia == "NÃO"){
                $dados['qualDeficiencia'] = ' ';
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
        $cargaHorariaBase = $dados['cargaHorariaBase'];
        $horarioTrabBase = $dados['horarioTrabBase'];
        dadosBase::find($idDadosBase)->update(['dadosPessoais' => '1', 'localTrabBase' => $localTrabBase, 'secretariaBase' => $secretariaBase, 'cargaHorariaBase' => $cargaHorariaBase, 'horarioTrabBase' => $horarioTrabBase,'nomeBase' => $nomeBase]);

    	$caminho = $idDadosBase.'/enderecoContatos';
    	return redirect()->to($caminho);
    }

    public function  enderecoContatos(Request $request){ 
        $idDadosBase = $request->id;

        $eC = enderecoContatos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();

        $usuario = Auth::user()->id;

        if ( $usuario == $idDadosBase){
            if (empty($eC[0])){
                return view('censoEnderecoContatos');
            }else{
                $eC = $eC[0];
                return view('censoEnderecoContatosUpdate',compact('eC'));
            }
        } else{
           return view('semPermissao');
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

        if (($request->complementoEC == "") || ($request->complementoEC == " ")){
                $dados['complementoEC'] = ' ';
            }
        if (($request->telResidencial == "")||($request->telResidencial == " ")){
                $dados['telResidencial'] = ' ';
            }
        if (($request->email == "")||($request->email == " ")){
                $dados['email'] = ' ';
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

        $usuario = Auth::user()->id;

        if ( $usuario == $idDadosBase){
            if (empty($doc[0])){
                return view('censoDocumentacao', compact( 'estados', 'cidades'));
            }else{
                $doc = $doc[0];
                return view('censoDocumentacaoUpdate', compact( 'estados', 'cidades','doc'));
            }
        } else{
            return view('semPermissao');
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

        if (($request->certMilitar == "") || ($request->certMilitar == " ")){
                $dados['certMilitar'] = ' ';
        }
        if (($request->certMilitarSituacao == "") || ($request->certMilitarSituacao ==" ")){
                $dados['certMilitarSituacao'] = ' ';
        }
        if (($request->dataCertMilitar == "") || ($request->dataCertMilitar == " ")){
                $dados['dataCertMilitar'] = ' ';
        }
        if (($request->tipoCertMilitar == "") || ($request->tipoCertMilitar == " ")){
                $dados['tipoCertMilitar'] = ' ';
        }
        if (($request->ufCertMilitar == "") || ($request->ufCertMilitar == " ")){
                $dados['ufCertMilitar'] = ' ';
        }
        if (($request->numCNH == "") || ($request->numCNH == " ")){
                $dados['numCNH'] = ' ';
        }
        if (($request->registroCNH == "") || ($request->registroCNH == " ")){
                $dados['registroCNH'] = ' ';
        }
        if (($request->categoriaCNH == "") || ($request->Categoria == " ")){
                $dados['categoriaCNH'] = ' ';
        }
        if (($request->dataEmissaoCNH == "") || ($request->dataEmissaoCNH == " ")){
                $dados['dataEmissaoCNH'] = ' ';
        }
        if (($request->ufCNH == "") || ($request->ufCNH == " ")){
                $dados['ufCNH'] = ' ';
        }
        if (($request->dataValidadeCNH == "") || ($request->dataValidadeCNH == " ")){
                $dados['dataValidadeCNH'] = ' ';
        }
        if (($request->primeiraHabilitacao == "") || ($request->primeiraHabilitacao == " ")){
                $dados['primeiraHabilitacao'] = ' ';
        }
        if (($request->conselhoProfissional == "") || ($request->conselhoProfissional == " ")){
                $dados['conselhoProfissional'] = ' ';
        }
        if (($request->numConselhoProf == "") || ($request->numConselhoProf == " ")){
                $dados['numConselhoProf'] = ' ';
        }
        if (($request->dataEmissaoConselhoProf == "") || ($request->dataEmissaoConselhoProf == " ")){
                $dados['dataEmissaoConselhoProf'] = ' ';
        }
        if (($request->dataValidadeConselhoProf == "") || ($request->dataValidadeConselhoProf == " ")){
                $dados['dataValidadeConselhoProf'] = ' ';
        }
        if (($request->pisPasep == "") || ($request->pisPasep == " ")){
                $dados['pisPasep'] = ' ';
        }
        if (($request->dataCadPisPasep == "") || ($request->dataCadPisPasep == " ")){
                $dados['dataCadPisPasep'] = ' ';
        }
        if ($request->cidadeVotacao == "0"){
                $dados['cidadeVotacao'] = ' ';
        }


        $this->validate($request, $this->documentacao->rules, $this->documentacao->messages);

        if(empty($doc[0])){
        	$insert = $this->documentacao->create($dados);
        }else{
        	documentacao::where('idDadosBase',$idDadosBase)->first()->update($dados);  	
        }
        $caminho = $idDadosBase.'/vincEmpregaticio';
    	return redirect()->to($caminho);

    }

    public function vincEmpreg(Request $request){ 
        $idDadosBase = $request->id;
        $usuario = Auth::user()->id;

        $vincEmpreg = vinculoEmpregaticio::where(function($query) use($idDadosBase){
           if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();

        if ( $usuario == $idDadosBase){
            if (empty($vincEmpreg[0])){
                return view('censoVinculoEmpregaticio', compact( 'idDadosBase'));
            }else{
                $vincEmpreg = $vincEmpreg[0];
                return view('censoVinculoEmpregaticioUpdate', compact( 'idDadosBase', 'vincEmpreg'));
            }
        } else{
            return view('semPermissao');
        }      
    }

    public function insereVincEmpreg(Request $request){ 
        $dados = $request->all();
        $idDadosBase = $request->id;
        $dados['idDadosBase'] = $idDadosBase;
        $vincEmpreg = vinculoEmpregaticio::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();  
        $this->validate($request, $this->vinculoEmpregaticio->rules, $this->vinculoEmpregaticio->messages);

        if (($request->qualVinculo == "") || ($request->qualVinculo == " ")){
                $dados['qualVinculo'] = ' ';
        }
        if (($request->orgaoEmpregaticio == "") || ($request->orgaoEmpregaticio == " ")){
                $dados['orgaoEmpregaticio'] = ' ';
        }
        if (($request->cargoVinculo == "") || ($request->cargoVinculo == " ")){
                $dados['cargoVinculo'] = ' ';
        }
        if (($request->cargaHorariaVinculo == "") || ($request->cargaHorariaVinculo == " ")){
                $dados['cargaHorariaVinculo'] = ' ';
        }
        if (($request->turnoVinculo == "") || ($request->turnoVinculo == " ")){
                $dados['turnoVinculo'] = ' ';
        }
        if (($request->horarioDiasTrabVinculo == "") || ($request->horarioDiasTrabVinculo == " ")){
                $dados['horarioDiasTrabVinculo'] = ' ';
        }
        if (($request->cargoGratificado == "") || ($request->cargoGratificado == " ")){
                $dados['cargoGratificado'] = ' ';
        }

        if(empty($vincEmpreg[0])){
            $insert = $this->vinculoEmpregaticio->create($dados);
        }else{
            vinculoEmpregaticio::where('idDadosBase',$idDadosBase)->first()->update($dados);   
        }
        $caminho = $idDadosBase.'/dependenteRegras';
        return redirect()->to($caminho);
    }

    public function dependenteRegras(Request $request){ 
        $idDadosBase = $request->id;
        return view('censoDependentesRegras', compact('idDadosBase'));
    }

    public function dependentes(Request $request){ 
    	$idDadosBase = $request->id;
    	$dependentes = dependente::where(function($query) use($idDadosBase){
    		if($idDadosBase)
    			$query->where('idDadosBase', '=' , $idDadosBase);
    	})->paginate(5);

        $usuario = Auth::user()->id;

        if ( $usuario == $idDadosBase){
            return view('censoDependentes', compact('dependentes'));
        } else{
             return view('semPermissao');
        }
    }

    public function  novoDependente(Request $request){ 
        $idDadosBase = $request->id;
        $dependentes = dependente::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->paginate(5);

        $usuario = Auth::user()->id;
        if ( $usuario == $idDadosBase){
            return view('censoNovoDependente');
        } else{
             return view('semPermissao');
        } 
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

        if (Gate::denies('edit_dependente', $dependente[0])){
            //abort(403, 'Não Autorizado');
            return view('semPermissao');
        }

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

    public function  anexarArquivos(Request $request){ 
        $idDadosBase = $request->id;
        $arquivos = arquivos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->paginate(5);

        $usuario = Auth::user()->id;
        if ( $usuario == $idDadosBase){
            return view('censoAnexarArquivos', compact('arquivos'));
        } else{
             return view('semPermissao');
        }   
    }

    public function novoUpDocumento(Request $request){ 
        $idDadosBase = $request->id;
        $arquivos = arquivos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->paginate(5);

       $usuario = Auth::user()->id;
        if ( $usuario == $idDadosBase){
             return view('censoNovoDocumento');
        } else{
             return view('semPermissao');
        }     
    }

    public function insereArquivo(Request $request){  
        $dados = $request->all();
        $idDadosBase = $request->id;
        $dados['idDadosBase'] = $idDadosBase;
        $this->validate($request, $this->arquivos->rules, $this->arquivos->messages);
        $data = date('Y-m-d h:m:s');

        $arquivo = file_get_contents(Input::file('arquivoDoc')->getRealPath());
        $arquivoNome = Input::file('arquivoDoc')->getClientOriginalName();
        $size = Input::file('arquivoDoc')->getSize();
        $mime = Input::file('arquivoDoc')->getMimeType();
        
        DB::table('arquivos')->insert(array('arquivoDoc' => $arquivo, 
                                            'nomeArquivo' => $arquivoNome,
                                            'mime' => $mime,
                                            'size' => $size,
                                            'idDadosBase' => $dados['idDadosBase'], 
                                            'tipoDocumento' => $dados['tipoDocumento'],
                                            'created_at' => $data,
                                            'updated_at' => $data));
        
        $caminho = $idDadosBase.'/anexaArquivos';
        return redirect()->to($caminho);
    }

    public function viewArquivo(Request $request){ 
        $id = $request->id;
        $file = DB::select('SELECT * from arquivos where idArquivo = ?',array($id));
        $arquivo = $file[0]->arquivoDoc;

        $idDadosBase = $file[0]->idDadosBase;
        $arq = arquivos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->paginate(5);

        if (Gate::denies('view_arquivos', $arq[0])){
            //abort(403, 'Não Autorizado');
            return view('semPermissao');
        }

        return Response($arquivo, 200, array('Content-type'=>$file[0]->mime, 'Content-length'=>$file[0]->size));
    }

    public function delArquivo(Request $request){ 
        $idArquivo = $request->id;
        $arquivo = arquivos::where(function($query) use($idArquivo ){
            if($idArquivo)
                $query->where('idArquivo', '=' , $idArquivo );
        })->get();
        arquivos::where('idArquivo',$idArquivo)->delete(); 
        return redirect()->to($arquivo[0]->idDadosBase.'/anexaArquivos');  
    }

    public function totalArquivosAnexados($id){
        $idDadosBase = $id;
        $tArquivos = arquivos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->count();
        return $tArquivos;
    }

    public function arquivosRegras(Request $request){ 
        $idDadosBase = $request->id;
        return view('censoAnexaArquivosRegras', compact('idDadosBase'));
    }


    public function  impressaoCensoF(Request $request){ 

    	$idDadosBase = $request->id;
        $usuario = Auth::user()->id;

        if ( $usuario == $idDadosBase ){
            $dadosBase = dadosBase::where(function($query) use($idDadosBase){
                if($idDadosBase)
                    $query->where('idDadosBase', '=', $idDadosBase);
                })->get();

            $dadosPessoais = dadosPessoais::where(function($query) use($idDadosBase){
                if($idDadosBase)
                    $query->where('idDadosBase', '=', $idDadosBase);
                })->get();
            if (!empty($dadosPessoais[0])){

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
            }

            $vinculoEmpregaticio = vinculoEmpregaticio::where(function($query) use($idDadosBase){
                if($idDadosBase)
                    $query->where('idDadosBase', '=', $idDadosBase);
                })->get();

    	    $dadosEndContato = enderecoContatos::where(function($query) use($idDadosBase){
    		    if($idDadosBase)
    			    $query->where('idDadosBase', '=', $idDadosBase);
    	        })->get();

    	     $dadosDocumentacao = documentacao::where(function($query) use($idDadosBase){
    		    if($idDadosBase)
    			    $query->where('idDadosBase', '=', $idDadosBase);
    	        })->get();
             if (!empty($dadosDocumentacao[0])){
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
                if ($dadosDocumentacao[0]['ufCertMilitar'] != ' '){
    	            $dadosDocumentacao[0]['ufCertMilitar'] = $ufCertMilitar[0]['estadoNome'];
                }

                $ufCNHId=$dadosDocumentacao[0]['ufCNH'];
    	        $ufCNH= estado::where(function($query) use($ufCNHId){
    		       if($ufCNHId)
    			       $query->where('estadoId', '=', $ufCNHId);
    	           })->get();
                if ($dadosDocumentacao[0]['ufCNH'] != ' '){
    	           $dadosDocumentacao[0]['ufCNH'] = $ufCNH[0]['estadoNome'];
                }
            }

    	    $dadosDependente = dependente::where(function($query) use($idDadosBase){
    		    if($idDadosBase)
    			     $query->where('idDadosBase', '=' , $idDadosBase);
    	        })->get();

            $tArquivos = censoController::totalArquivosAnexados($idDadosBase);

            if (empty($dadosPessoais[0]) || empty($dadosEndContato[0]) ){
                return view('semPermissao');
            }

    	    return view('censoImpressaoFichas', compact('dadosBase', 'dadosPessoais', 'dadosEndContato', 'vinculoEmpregaticio', 'dadosDocumentacao', 'dadosDependente', 'tArquivos'));
        } else{
             return view('semPermissao');
        }  
    }


    public function impressaoPDF(Request $request){
        $idDadosBase = $request->id;
        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dados Funcionais'),0,1);
        $dadosBase = dadosBase::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();

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
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Carga Hóraria: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, strtoupper(utf8_decode($dadosBase[0]->cargaHorariaBase)),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Hór/dias trab: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(0,5, strtoupper(utf8_decode($dadosBase[0]->horarioTrabBase)),0,1);

        $vinculoEmpregaticio = vinculoEmpregaticio::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=', $idDadosBase);
        })->get();
        $this->pdf->Ln(2);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Vínculo Empregatício - PMSMJ'),0,1);
        $this->pdf->Ln(1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(60,5, utf8_decode('Cargo/Função gratificada? '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(58, 5, utf8_decode($vinculoEmpregaticio[0]->funcaoGratificada),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Cargo: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($vinculoEmpregaticio[0]->cargoGratificado),0,1);

        $this->pdf->Ln(2);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Outro Vínculo Empregatício'),0,1);
        $this->pdf->Ln(1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(55,5, utf8_decode('Vínculo Empregatício? '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(58, 5, utf8_decode($vinculoEmpregaticio[0]->vinculoEmpregaticio),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Qual? '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($vinculoEmpregaticio[0]->qualVinculo),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(20,5, utf8_decode('Órgão: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(58, 5, utf8_decode($vinculoEmpregaticio[0]->orgaoEmpregaticio),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Cargo: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($vinculoEmpregaticio[0]->cargoVinculo),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(30,5, utf8_decode('Carga Hor.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($vinculoEmpregaticio[0]->cargaHorariaVinculo),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(15,5, utf8_decode('Turno: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($vinculoEmpregaticio[0]->turnoVinculo),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(30,5, utf8_decode('Dias Trab.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(60, 5, utf8_decode($vinculoEmpregaticio[0]->horarioDiasTrabVinculo),0,1);

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
        if ($dadosDocumentacao[0]['ufCertMilitar'] != ' '){
          $dadosDocumentacao[0]['ufCertMilitar'] = $ufCertMilitar[0]['estadoNome'];
        }
        $ufCNHId=$dadosDocumentacao[0]['ufCNH'];
        $ufCNH= estado::where(function($query) use($ufCNHId){
            if($ufCNHId)
                $query->where('estadoId', '=', $ufCNHId);
        })->get();
        if ($dadosDocumentacao[0]['ufCNH'] != ' '){
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
        $this->pdf->Cell(26,5, utf8_decode('Categoria: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(37,5, utf8_decode($dadosDocumentacao[0]->categoriaCNH),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(27,5, utf8_decode('1ª Habil.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(27,5, utf8_decode($dadosDocumentacao[0]->primeiraHabilitacao),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(34,5, utf8_decode('Data de Val.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(80,5, utf8_decode($dadosDocumentacao[0]->dataValidadeCNH),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Conselho Prof.: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(103,5, utf8_decode($dadosDocumentacao[0]->conselhoProfissional),0,0);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(35,5, utf8_decode('Orgão Emissor: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120,5, utf8_decode($dadosDocumentacao[0]->orgaoEmissorConselhoProf),0,1);
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

        $tArquivos = censoController::totalArquivosAnexados($idDadosBase);

        $this->pdf->Ln(1);
        $this->pdf->SetFont('Courier','BI',12);
        $this->pdf->Cell(70,5,utf8_decode('Total de arquivos Anexados: '),0,0);
        $this->pdf->Cell(10,5,utf8_decode($tArquivos),0,1);
        $this->pdf->Ln(1);

        $this->pdf->Ln(1);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Endereço e Contatos'),0,1);
        $this->pdf->Ln(1);
        $dadosEndereco = enderecoContatos::where(function($query) use($idDadosBase){
            if($idDadosBase)
                $query->where('idDadosBase', '=' , $idDadosBase);
        })->get();
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(21,5, utf8_decode('Endereço: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120,5, utf8_decode($dadosEndereco[0]->enderecoResidencialEC),0,0); 
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(16,5, utf8_decode('Número: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(30,5, utf8_decode($dadosEndereco[0]->numeroEC),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(29,5, utf8_decode('Complemento: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(110,5, utf8_decode($dadosEndereco[0]->complementoEC),0,0); 
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(16,5, utf8_decode('Bairro: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(45,5, utf8_decode($dadosEndereco[0]->bairroEC),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(17,5, utf8_decode('Cidade: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120,5, utf8_decode($dadosEndereco[0]->cidadeEC),0,1); 
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(17,5, utf8_decode('Estado: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(120,5, utf8_decode($dadosEndereco[0]->estadoEC),0,0); 
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(10,5, utf8_decode('CEP: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(45,5, utf8_decode($dadosEndereco[0]->cep),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(38,5, utf8_decode('Tel. Residencial: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(80,5, utf8_decode($dadosEndereco[0]->telResidencial),0,0); 
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(31,5, utf8_decode('Tel. Celular: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(50,5, utf8_decode($dadosEndereco[0]->telCelular),0,1);
        $this->pdf->SetFont('Courier','B',11);
        $this->pdf->Cell(14,5, utf8_decode('E-mail: '),0,0);
        $this->pdf->SetFont('Courier','',11);
        $this->pdf->Cell(100,5, utf8_decode($dadosEndereco[0]->email),0,1);


        $this->pdf->Ln(1);
        $this->pdf->SetFont('Courier','BI',15);
        $this->pdf->Cell(10,5,utf8_decode('Dependentes'),0,1);
        $this->pdf->Ln(1);
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


        $this->pdf->Output(utf8_decode("Censo_2018_PMSMJ_".$dadosBase[0]->matriculaBase.".pdf"),"D");
        exit;
    
    }

    public function viewTrocaSenha(Request $request){
        return view('trocaSenha');
    }

    public function updateTrocaSenha(Request $request){
        $usuario = Auth::user();

        if ( ! $request->password == ''){
            $usuario->trocaSenha = 1;
            $usuario->password = bcrypt($request->password);
        }
        $usuario->save();
        return view('confirmaTrocaSenha');
    }
}