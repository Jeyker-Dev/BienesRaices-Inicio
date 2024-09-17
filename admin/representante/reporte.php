<?php
require('../fpdf186/fpdf.php');

// Database
require '../../includes/config/database.php';
$database = conectarDB();

// Array Errors
    $errores = [];

    $ci_representante = '';
    $fecha_reporte = date('y-m-d');

    
if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $ci_representante = mysqli_real_escape_string( $database, $_POST['CiRepresentante'] );
    
    // Consulta SQL para obtener propiedades según los criterios de filtrado
    $consulta = "SELECT * FROM representante WHERE Ci_Representante = $ci_representante";

}   // Here End If

// Query to See data from Sellers
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
    
    //Titulo
    $this->setXY(80,100);
    $this->Cell(70,10,'Reporte de Representantes',0,0,'C');

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
$pdf->SetFont('Arial','B',9);


$pdf -> Cell(30, 10, 'Ci Representante', 1, 0, 'C', 0);
$pdf -> Cell(30, 10, 'Nombre', 1, 0, 'C', 0);
$pdf -> Cell(30, 10, 'Apellido', 1, 0, 'C', 0);
$pdf -> Cell(30, 10, 'Telefono', 1, 0, 'C', 0);
$pdf -> Cell(50, 10, 'Correo', 1, 0, 'C', 0);
$pdf -> Cell(30, 10, 'Fecha Reporte', 1, 1, 'C', 0);

while($representante = $resultado -> fetch_assoc() )
{
    $pdf -> Cell(30, 10, $representante['Ci_Representante'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $representante['Nombre_repr'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $representante['Apellido_repr'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $representante['Tlf_repre'], 1, 0, 'C', 0);
    $pdf -> Cell(50, 10, $representante['Correo_repre'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $fecha_reporte, 1, 1, 'C', 0);
}   // Here End While


$pdf->Output();
?>