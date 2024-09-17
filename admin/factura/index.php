<?php
    require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
    require '../../includes/config/database.php';

    
    // Dialogo
    require '../../includes/template/dialogos.php';

// Database
    $database = conectarDB();

// Start Session
    $auth = estaAutenticado();

//Write Query
        $query = "SELECT * FROM factura";

        // Consult Database
        $resultadoConsulta = mysqli_query($database, $query);
    
        // Show Conditional Message
        $resultado = $_GET['resultado'] ?? null;

    // If Session ain't right go back to index
    if(!$auth)
    {
        header('Location: /');
    }   // Here End If


?>

<main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php   if( intval($resultado) === 1): ?>
            <p class="alerta exito">Factura Creada Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Factura Actualizada Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Factura Eliminada Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/factura/crear.php" class="boton boton-verde">Nueva Factura</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="factura all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Factura</th>
                        <th>Gestion Compra ID</th>
                        <th>CI Cliente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $factura = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $factura['id']; ?> </td>
                        <td>  <?php echo $factura['Fecha_Factura']; ?></td>
                        <td>  <?php echo $factura['GestionCompra_Id']; ?></td>
                        <td>  <?php echo $factura['Client_CI']; ?></td>
                        <td>

                        <a href="/admin/factura/actualizar.php?id=<?php echo $factura['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $factura['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/factura/reporte.php" class="boton-verde-block">Reporte</a> -->

                    </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

    </main>

<?php
    // Close Conecction
    mysqli_close($database);
    incluirTemplate('footer');

?>