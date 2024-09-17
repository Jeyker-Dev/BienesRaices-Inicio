<?php
require('../fpdf186/fpdf.php');

// Database
require '../../includes/config/database.php';
$database = conectarDB();

$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorID = '';
$tipopropiedad_id = '';
$status_id = '';
$representante_id = '';
$categoria_id = '';
$fecha_reporte = date('d-m-y');
$hora_reporte = time();
$fecha_inicio = '';
$fecha_fin = '';
$x = 0;

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $precio = mysqli_real_escape_string( $database, $_POST['Precio'] );
    $habitaciones = mysqli_real_escape_string( $database, $_POST['Habitaciones'] );
    $wc = mysqli_real_escape_string( $database, $_POST['Wc'] );
    $estacionamiento = mysqli_real_escape_string( $database, $_POST['Estacionamiento'] );
    $vendedorID = mysqli_real_escape_string( $database, $_POST['Vendedor'] );
    $tipopropiedad_id = mysqli_real_escape_string( $database, $_POST['TipoPropiedad'] );
    $status_id = mysqli_real_escape_string( $database, $_POST['Status'] );
    $representante_id = mysqli_real_escape_string( $database, $_POST['Representante'] );
    $categoria_id = mysqli_real_escape_string( $database, $_POST['Categoria'] );
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

    $consulta = "SELECT * 
        FROM propiedades 
        WHERE creado BETWEEN '$fecha_inicio' AND '$fecha_fin'
        AND habitaciones >= $habitaciones  
        AND precio >= $precio;";
}   // Here End If

// Query to See data from propiedades
$resultado = mysqli_query($database, $consulta);

// Verificar si el email ya está en uso
$consulta_propiedades = "SELECT COUNT(*) AS TotalPropiedades FROM propiedades";
$resultado_propiedades = $database->query($consulta_propiedades);
$fila_propiedades = $resultado_propiedades->fetch_assoc();
$total_propiedades = $fila_propiedades['TotalPropiedades'];

$consulta_inner = "SELECT p.titulo,p.precio,p.habitaciones, p.wc, p.estacionamiento, p.creado, c.Categoria_Propiedad, t.TipoPropiedad
FROM propiedades p INNER JOIN categoria c on p.categoria_id=c.id
INNER JOIN tipopropiedad t on p.tipopropiedad_id=t.id";
$resultado_inner = $database->query($consulta_inner);
$fila_propiedades = $resultado_inner->fetch_assoc();
$categoria_inner = $fila_propiedades['Categoria_Propiedad'];
$tipopropiedad_inner = $fila_propiedades['TipoPropiedad'];

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
    $this->Cell(70,10,'Reporte de Propiedades',0,1,'C');

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

$pdf -> Cell(40, 10, 'Titulo', 1, 0, 'C', true);
$pdf -> Cell(17, 10, 'Precio ($)', 1, 0, 'C', true);
$pdf -> Cell(17, 10, 'N. Hab.', 1, 0, 'C', true);
$pdf -> Cell(17, 10, utf8_decode('Baños'), 1, 0, 'C', true);
$pdf -> Cell(17, 10, 'N. Estac.', 1, 0, 'C', true);
$pdf -> Cell(30, 10, 'Categoria', 1, 0, 'C', true);
$pdf -> Cell(30, 10, 'Tipo de Propiedad', 1, 0, 'C', true);
$pdf -> Cell(20, 10, 'Fecha', 1, 1, 'C', true);

while($propiedades = $resultado -> fetch_assoc() )
{
    $pdf -> Cell(40, 10, utf8_decode ($propiedades['titulo']), 1, 0, 'C', 0);
    $pdf -> Cell(17, 10, $propiedades['precio'], 1, 0, 'C', 0);
    $pdf -> Cell(17, 10, $propiedades['habitaciones'], 1, 0, 'C', 0);
    $pdf -> Cell(17, 10, $propiedades['wc'], 1, 0, 'C', 0);
    $pdf -> Cell(17, 10, $propiedades['estacionamiento'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $categoria_inner, 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $tipopropiedad_inner, 1, 0, 'C', 0);
    $pdf -> Cell(20, 10, $propiedades['creado'], 1, 1, 'C', 0);
    $x++;
}   // Here End While

$pdf-> Ln(20);
$pdf -> Cell(60, 10,'Total Propiedades: ' . $x, 1, 0, 'C', 0);
$pdf->Output();
?>