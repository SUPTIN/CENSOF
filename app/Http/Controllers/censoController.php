<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\dadosBase;
use App\escolaridade;

class censoController extends Controller
{
	private $dadosBase;
	private $escolaridade;

	public function __construct(dadosBase $dadosBase, escolaridade $escolaridade){
		$this->dadosBase = $dadosBase;
		$this->escolaridades = $escolaridade;

	}

	 public function dadosBase(){ 
	 	$usuario = '1';

	 	$dBasicos = dadosBase::find($usuario);
        return view('welcome', compact('dBasicos'));
    }

    public function  dadosPessoais(escolaridade $escolaridades){ 

    	$escolaridades = $this->escolaridades->orderBy('id')->get();

        return view('censoDadosPessoais', compact('escolaridades'));
    }

    public function  enderecoContatos(){ 
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
