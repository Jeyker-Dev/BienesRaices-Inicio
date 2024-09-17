<?php
require('./fpdf186/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    

    // Arial bold 15
    $this->SetFont('Arial','B',15);
    
    // Movernos a la derecha
    $this->Cell(60);
    
    //Titulo
    $this->setXY(70,60);
    $this->Cell(70,10,'Grafico de Vendedores con Mas Ventas',0,1,'C');

    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}   // Here End Class


$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage();
$pdf->Image('./fpdf186/img/Logo Circular Administración de Propiedades Abstracto Minimalista Verde y Gris Oscuro .jpg', 0,0,100);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor( 68, 166, 212);
$pdf->setXY(150, 20);
$pdf->Image('imagenes/002.jpg', 0,80,200);

$pdf->Output();
?>