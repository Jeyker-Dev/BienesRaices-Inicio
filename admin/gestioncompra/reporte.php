<?php
require('../fpdf186/fpdf.php');

// Database
require '../../includes/config/database.php';
$database = conectarDB();

// Query to See data from Sellers
$consulta  = "SELECT * FROM categoria";
$resultado = mysqli_query($database, $consulta);

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(60);
    // Título
    $this->setXY(80,100);
    $this->Cell(70,10,'Reporte de Categorias',0,0,'C');
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
$pdf->Image('../fpdf186/img/Logo Circular Administración de Propiedades Abstracto Minimalista Verde y Gris Oscuro .jpg', 0,0,100);
$pdf->SetFont('Arial','B',10);

$pdf -> Cell(10, 10, 'ID', 1, 0, 'C', 0);
$pdf -> Cell(40, 10, 'Categoria', 1, 1, 'C', 0);
while($categoria = $resultado -> fetch_assoc() )
{
    $pdf -> Cell(10, 10, $categoria['id'], 1, 0, 'C', 0);
    $pdf -> Cell(40, 10, $categoria['Categoria_Propiedad'], 1, 1, 'C', 0);
}   // Here End While


$pdf->Output();
?>