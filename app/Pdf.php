<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Codedge\Fpdf\Fpdf\Fpdf;

class Pdf extends Fpdf
{
   public function header(){
        $this->Image('imagens/logo.png', 5, 5, 20);
        $this->SetFont('Arial','B',18);
        $this->SetX(40);
        $this->Cell(0,5, utf8_decode('Prefeitura Municipal de Santa Maria de Jetibá - ES'),15, 6, 'C');
        $this->SetFont('Arial','B',15);
        $this->SetX(30);
        $this->Cell(0, 8,'Censo Funcional - 2018', 15, 6, 'C');
        $this->SetFont('Arial','B',9);
        $this->SetX(-40);
        $this->Cell(40,10,utf8_decode('Página: ').$this->PageNo().'/{nb}',0, 1);
        $this->SetX(-5);
        $this->line(210,32, \Fpdf::GetX(),32);
        $this->Ln(3);
    }
    public function footer(){
        $this->SetXY(-15, -15);
        $this->line(0, $this->GetY()-2, $this->GetX()+15,$this->GetY()-2);
        $this->SetX(0);
        $this->SetFont('Arial','BI',8);
        $this->Cell(150, 0, utf8_decode('SUPTIN & RH - Censo Funcional PMSMJ/ES - Impresso: '.strftime('%d/%m/%Y às %T')),0,0,'R');
        $this->SetFont('Arial','IB',6);
        $this->Cell(50, 0, utf8_decode('Versão 1.0'),0,0,'R');
    }



}
