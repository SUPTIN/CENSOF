@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                      <div class="row">
                        <h4>Censo Funcional - Regras para adição de Dependentes</h4>
                      </div> 

                      <div class="row" align="justify">
                        <div class="col-sm-12"> 
                          <br>
                          <p style="color:red;"> Atenção:Observar as regras abaixo antes de marcar "SIM" nos campos </p>
                          <ul>
                             <li> Dependente para fins de Dedução de Imposto de renda?</li>
                             <li> Dependente para fins de Recebimento de Salário Família?</li> 
                          </ul>
                          <p> <b>Imposto de Renda:</b> Quem pode ser dependente de acordo com a legislação tributária?</p>
                          <ol>
                            <li> Companheiro(a) com quem o contribuiinte tenha filho(a) ou viva há mais de 5 anos, ou cônjugue, que, no ano anterior tenham recebido rendimentos, tributáveis ou não, até o limite estabelecido;</li>
                            <li> Filho(a) ou enteado(a), até 21 anos de idade, ou, em qualquer idade, quando incapacitdo física ou mentalmente para o trabalho;</li>
                            <li> Filho(a) ou enteado(a), se ainda estiverem cursando estabelecimento de ensino superior ou escola técnica de segundo grau, até 24 anos de idade;</li>
                            <li> Irmão(ã), neto(a) ou bisneto(a), sem arrimo dos pais, de quem o contribuinte detenha a guarda judicial, até 21 anos, ou em qualquer idade, quando incapacitado física ou mentalmente para trabalho;</li>
                            <li> Irmão(ã), neto(a) ou bisneto(a), sem arrimo dos pais, com idade de 21 anos até 24 anos, se ainda estiver cursando estabelecimento de ensino superior ou escola técnica de segundo grau, desde que o contribuinte tenha detido sua guarda judicial até os 21 anos;</li>
                            <li> Pais, avós e bisavós que, no ano anterior tenham recebido rendimentos, tributáveis ou não, até o limite estabelecido;</li>
                            <li> Menor pobre até 21 anos que o contribuinte crie e eduque e de quem detenha a guarda judicial;</li>
                            <li> Pessoa absolutamente incapaz, da qual o contribuinte seja tutor ou curador.</li>
                          </ol>
                          <b><p> Atenção: </p>
                          <ul>
                            <li> No caso de filhos de pais separados, o contribuinte poderá considerar como dependentes os que ficarem sob sua guarda em cumprimento de decisão judicial ou acordo homologado judicialmente.</li>
                            <li> O responsável pelo pagamento da pensão alimentícia não poderá efetuar a dedução do valor correspondente a dependente.</li>
                            <li> É vedada a dedução concomitante de um mesmo dependnete comun, no caso de contribuintes cônjuges/companheiros.</li>
                          </ul></b>
                          <br/>
                          <p><b>Salário Família:</b></p>
                          <p> Para ter direito ao salário-família o empregado precisa ter remuneração de até R$ 1319,18 (este valor é calculado considerando o total bruto de proventos de um mês completo).</p>
                          <p> É pago pelo número de filhos ou equiparados, até 14 anos de idades ou inválido de qualquer idade.</p>
                          <p> Equiparam-se aos filhos, mediante comprovação de dependência econômica, o enteado e o menor que esteja sob tutela do empregado. Em caso de marcação do campo, é necessária a comprovação por meio de cópia da Caderneta de Vacinação dos Filhos de 0 a 14 anos de idade e Comprovante de escolaridade dos filhos entre 07 e 14 anos de idade.</p>
                        </div>
                      </div> 

                      <div class="row" align="center">
                        <div class="col-sm-12"> 
                          <a href="dependentes" class="btn btn-primary"> 
                             Avançar <i aria-hidden="true" title="Adicionar anexo dos Documentos"> </i>
                          </a>
                        </div>
                      </div> 
                </div>
            </div>
      </div>
   </div>
</div>
@endsection

