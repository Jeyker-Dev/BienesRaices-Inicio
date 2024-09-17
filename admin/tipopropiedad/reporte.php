<?php
require('../fpdf186/fpdf.php');

// Database
require '../../includes/config/database.php';
$database = conectarDB();

// Query to See data from Sellers
$consulta_tipopropiedad  = "SELECT * FROM tipopropiedad";
$resultado_tipopropiedad = mysqli_query($database, $consulta_tipopropiedad);



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

}   // Here End If

// Consulta SQL para obtener el total de tipos de propiedades vendidas
$sql_total_tipos_propiedades = "SELECT COUNT(DISTINCT tipopropiedad_id) as total_tipos_propiedades
                                FROM propiedades
                                WHERE status_id = (SELECT id FROM status WHERE Tipo_Estado = 'no disponible')";
$result_total_tipos_propiedades = $database->query($sql_total_tipos_propiedades);
$row_total_tipos_propiedades = $result_total_tipos_propiedades->fetch_assoc();
$total_tipos_propiedades = $row_total_tipos_propiedades['total_tipos_propiedades'];

$consulta_inner_2 = "SELECT t.id, t.TipoPropiedad, COUNT(p.id) as Casas_Vendidas, SUM(p.precio) as Total_Ventas
FROM tipopropiedad t
JOIN propiedades p ON t.id = p.vendedorId
WHERE p.status_id = (SELECT id from status where Tipo_Estado = 'No Disponible')
GROUP BY t.id
HAVING Total_Ventas >= $recaudado
ORDER BY Total_Ventas DESC";

// Query to See data from propiedades
$resultado_inner_2 = mysqli_query($database, $consulta_inner_2);


$consulta_inner = "SELECT tp.TipoPropiedad, c.Categoria_Propiedad, COUNT(p.id) as total_vendidas, SUM(p.precio) as total_recaudado
        FROM propiedades p
        INNER JOIN tipopropiedad tp ON p.tipopropiedad_id = tp.id
        INNER JOIN categoria c ON p.categoria_id = c.id
        INNER JOIN status s ON p.status_id = s.id
        WHERE s.Tipo_Estado = 'no disponible'
        GROUP BY tp.TipoPropiedad, c.Categoria_Propiedad";

// Query to See data from propiedades
$resultado_inner = mysqli_query($database, $consulta_inner);


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
    $this->Cell(70,10,'Reporte de Tipos de Propiedades',0,1,'C');

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



$x = 0;
$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage();
$pdf->Image('../fpdf186/img/Logo Circular Administración de Propiedades Abstracto Minimalista Verde y Gris Oscuro .jpg', 0,0,100);
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor( 68, 166, 212);

$pdf -> Cell(40, 10, 'T.Propiedad', 1, 0, 'C', true);
// $pdf -> Cell(30, 10, 'Categoria', 1, 0, 'C', true);
$pdf -> Cell(30, 10, 'T.Ventas', 1, 0, 'C', true);
$pdf -> Cell(30, 10, 'Recaudado', 1, 1, 'C', true);

while($propiedades = $resultado_inner_2 -> fetch_assoc() )
{
    $pdf -> Cell(40, 10, $propiedades['TipoPropiedad'], 1, 0, 'C', 0);
    // $pdf -> Cell(30, 10, $propiedades['Categoria_Propiedad'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $propiedades['Casas_Vendidas'], 1, 0, 'C', 0);
    $pdf -> Cell(30, 10, $propiedades['Total_Ventas'], 1, 1, 'C', 0);
    $x++;
}   // Here End While

$pdf-> Ln(20);
 $pdf -> Cell(60, 10,'Total Propiedades: ' . $x, 1, 0, 'C', 0);
$pdf->Output();
?>