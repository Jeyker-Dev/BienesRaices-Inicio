<?php

require './includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
    require './includes/config/database.php';

// Database
    $database = conectarDB();

// Start Session
    $auth = estaAutenticado();

//Write Query
        $consulta_propiedades = "SELECT * FROM propiedades";
        // Consult Database
        $resultadoConsultaPropiedades = mysqli_query($database, $consulta_propiedades);

//Write Query
$consulta_vendedores = "SELECT * FROM vendedores";
// Consult Database
$resultadoConsultaVendedores = mysqli_query($database, $consulta_vendedores);

//Write Query
$consulta_cliente = "SELECT * FROM cliente";
// Consult Database
$resultadoConsultaCliente = mysqli_query($database, $consulta_cliente);

        // Query to See Total of Propiedades
$consulta_propiedades_total = "SELECT COUNT(*) AS TotalPropiedades FROM propiedades";
$resultado_propiedades_total = $database->query($consulta_propiedades_total);
$fila_propiedades = $resultado_propiedades_total->fetch_assoc();
$total_propiedades = $fila_propiedades['TotalPropiedades'];

// Query to See Total of Sellers
$consulta_vendedores_total = "SELECT COUNT(*) AS TotalVendedores FROM vendedores";
$resultado_vendedores_total = $database->query($consulta_vendedores_total);
$fila_vendedores = $resultado_vendedores_total->fetch_assoc();
$total_vendedores = $fila_vendedores['TotalVendedores'];

// Consulta SQL para obtener el total de propiedades disponibles
$sql_total_propiedades_disponibles = "SELECT COUNT(id) as total_propiedades_disponibles
                                    FROM propiedades
                                    WHERE status_id = (SELECT id FROM status WHERE Tipo_Estado = 'disponible')";
$result_total_propiedades_disponibles = $database->query($sql_total_propiedades_disponibles);
$row_total_propiedades_disponibles = $result_total_propiedades_disponibles->fetch_assoc();
$total_propiedades_disponibles = $row_total_propiedades_disponibles['total_propiedades_disponibles'];

$sql_total_propiedades_no_disponibles = "SELECT COUNT(id) as total_propiedades_no_disponibles
                                        FROM propiedades
                                        WHERE status_id != (SELECT id FROM status WHERE Tipo_Estado = 'disponible')";
$result_total_propiedades_no_disponibles = $database->query($sql_total_propiedades_no_disponibles);
$row_total_propiedades_no_disponibles = $result_total_propiedades_no_disponibles->fetch_assoc();
$total_propiedades_no_disponibles = $row_total_propiedades_no_disponibles['total_propiedades_no_disponibles'];

// Consulta SQL para obtener el total de propiedades vendidas en el año específico
$sql_total_propiedades_vendidas_anio = "SELECT COUNT(id) as total_propiedades_vendidas_anio
                                        FROM propiedades
                                        WHERE status_id = (SELECT id FROM status WHERE Tipo_Estado = 'no disponible')
                                        AND YEAR(creado) = '2024'";
$result_total_propiedades_vendidas_anio = $database->query($sql_total_propiedades_vendidas_anio);
$row_total_propiedades_vendidas_anio = $result_total_propiedades_vendidas_anio->fetch_assoc();
$total_propiedades_vendidas_anio = $row_total_propiedades_vendidas_anio['total_propiedades_vendidas_anio'];

// Consulta SQL para obtener el total de clientes
$sql_total_clientes = "SELECT COUNT(*) as total_clientes FROM cliente";
$result_total_clientes = $database->query($sql_total_clientes);
$row_total_clientes = $result_total_clientes->fetch_assoc();
$total_clientes = $row_total_clientes['total_clientes'];

?>

<main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

            <table class="representante all">
                <thead>
                    <tr>
                        <th>Total de Anuncios</th>
                        <th>Total Propiedades Disponibles</th>
                        <th>Total Propiedades Vendidas</th>
                        <th>Ventas Este Año</th>
                        <th>Total Vendedores</th>
                        <th>Total Clientes</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>

                        <td>  <?php echo $total_propiedades; ?> </td>
                        <td>  <?php echo $total_propiedades_disponibles ?> </td>
                        <td>  <?php echo $total_propiedades_no_disponibles; ?></td>
                        <td>  <?php echo $total_propiedades_vendidas_anio; ?></td>
                        <td>  <?php echo $total_vendedores; ?> </td>
                        <td> <?php echo $total_clientes; ?> </td>

                    </tr>

                </tbody>

            </table>

        <div class="contenedor-botones">
            <a href="reporte1.php" class="boton-verde">Grafico Categoria</a>
            <a href="reporte2.php" class="boton-verde">Grafico Vendedores</a>
            <a href="reporte3.php" class="boton-verde">Grafico Habitaciones</a>
        </div>

    </main>

<?php
    // Close Conecction
    mysqli_close($database);
    incluirTemplate('footer');

?>