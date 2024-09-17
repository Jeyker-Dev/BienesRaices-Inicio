<?php
    require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
    require '../../includes/config/database.php';

// Database
    $database = conectarDB();
    
    // Dialogo
    require '../../includes/template/dialogos.php';

// Start Session
    $auth = estaAutenticado();

//Write Query
        $query = "SELECT g.id, g.Monto_Final, s.Fecha AS FechaSolicitud, m.Condicion AS TipoMetodo
        FROM gestioncompra g
        INNER JOIN solicitud_compra s ON g.Solicitud_Compra_Id = s.id
        INNER JOIN metodo_pago m ON g.MetodoPago_Id = m.id;";

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
            <p class="alerta exito">Compra Creada Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Compra Actualizada Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Compra Eliminada Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/gestioncompra/crear.php" class="boton boton-verde">Nueva Compra</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="gestioncompra all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Monto Final</th>
                        <th>Solicitud Fecha</th>
                        <th>Metodo Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $gestioncompra = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $gestioncompra['id']; ?> </td>
                        <td>  <?php echo $gestioncompra['Monto_Final']; ?></td>
                        <td>  <?php echo $gestioncompra['FechaSolicitud']; ?></td>
                        <td>  <?php echo $gestioncompra['TipoMetodo']; ?></td>
                        <td>

                        <a href="/admin/gestioncompra/actualizar.php?id=<?php echo $gestioncompra['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $gestioncompra['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/gestioncompra/reporte.php" class="boton-verde-block">Reporte</a> -->

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