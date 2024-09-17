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
    $query = "SELECT * FROM status";

    // Consult Database
    $resultadoConsulta = mysqli_query($database, $query);

    // Show Conditional Message
    $resultado = $_GET['resultado'] ?? null;


?>

<main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php   if( intval($resultado) === 1): ?>
            <p class="alerta exito">Status Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Status Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Status Eliminado Correctamente</p>
        <?php endif;      ?>
         
        <div class="contenedor-botones">
            <a href="/admin/status/crear.php" class="boton boton-verde">Nuevo Status</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
        </div>

            <table class="categoria all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $status = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $status['id']; ?> </td>
                        <td>  <?php echo $status['Tipo_Estado']; ?></td>
                        <td>
                            
                        <a href="/admin/status/actualizar.php?id=<?php echo $status['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $status['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/status/reporte.php" class="boton-verde-block">Reporte</a> -->

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