<?php
require('../fpdf186/fpdf.php');

// Database
require '../../includes/config/database.php';
$database = conectarDB();

// Query to See data from Sellers
$consulta_vendedores  = "SELECT * FROM vendedores";
$resultado_vendedores = mysqli_query($database, $consulta_vendedores);

$nombre_vendedor = '';
$apellido_vendedor = '';

$fecha_reporte = date('y-m-d');
$hora_reporte = date('H:i:s');
$fecha_inicio = '';
$fecha_fin = '';

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $recaudado = mysqli_real_escape_string( $database, $_POST['Recaudado'] );
    $fecha_inicio = mysqli_real_escape_string( $database, $_POST['FechaInicio'] );
    $fecha_fin = mysqli_real_escape_string( $database, $_POST['FechaFin'] );
    
    // Convertir las fechas al formato correcto (Y-m-d)
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    /*
    // Consulta SQL para obtener propiedades según los criterios de filtrado
    $consulta = "SELECT * FROM propiedades WHERE precio <= $precio or habitaciones <= $habitaciones 
    or wc <= $wc or estacionamiento <= $estacionamiento";
    */
}   // Here End If

$consulta_inner = "SELECT v.id, v.nombre, v.apellido, COUNT(p.id) as Casas_Vendidas, SUM(p.precio) as Total_Ventas
FROM vendedores v
JOIN propiedades p ON v.id = p.vendedorId
WHERE p.status_id = (SELECT id from status where Tipo_Estado = 'No Disponible')
GROUP BY v.id
HAVING Total_Ventas >= $recaudado
ORDER BY Total_Ventas DESC";

// Query to See data from propiedades
$resultado_inner = mysqli_query($database, $consulta_inner);


// Consulta SQL para obtener el total de vendedores que han vendido
$sql_total_vendedores = "SELECT COUNT(DISTINCT t.id) as total_tipopropiedades
                         FROM tipopropiedades t
                         INNER JOIN propiedades p ON t.id = p.vendedorId
                         INNER JOIN status s ON p.status_id = s.id
                         WHERE s.Tipo_Estado = 'No Disponible'";

$result_total_vendedores = $database->query($sql_total_vendedores);
$row_total_vendedores = $result_total_vendedores->fetch_assoc();
$total_vendedores = $row_total_vendedores['total_vendedores'];

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    
    global $fecha_reporte, $hora_reporte;

    // Arial bold 15
    $this->SetFont('Arial','B',15);
    
    // Movernos a la derecha
    $this->Cell(60);
    
    //Titulo
    $this->setXY(130, 20);
    $this->Cell(50, 10, 'Fecha '  . $fecha_reporte, 1, 1, 'C');
    $this->setXY(130, 30);
    // $this->Cell(50, 10, 'Hora '  . $hora_reporte, 1, 1, 'C');
    $this->setXY(70,60);
    $this->Cell(70,10,'Reporte de Vendedores',0,1,'C');

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
$pdf->SetFillColor( 68, 166, 212);

$pdf -> Cell(30, 10, 'Nombre', 1, 0, 'C', true);
$pdf -> Cell(30, 10, 'Apellido', 1, 0, 'C', true);
$pdf -> Cell(17, 10, 'Vendidas', 1, 0, 'C', true);
$pdf -> Cell(30, 10, 'Recaudado', 1, 1, 'C', true);

while($vendedores = $resultado_inner -> fetch_assoc() )
{
    $pdf -> Cell(30, 10, $vendedores['nombre'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $vendedores['apellido'], 1, 0, 'C', 0);
    $pdf -> Cell(17, 10, $vendedores['Casas_Vendidas'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $vendedores['Total_Ventas'], 1, 1, 'C', 0);
}   // Here End While

$pdf-> Ln(20);
$pdf -> Cell(60, 10,'Total Vendedores: ' . $total_vendedores, 1, 0, 'C', 0);
$pdf->Output();
?>