<?php
    require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

    // Dialogo
    require '../../includes/template/dialogos.php';

// Import Conecction
    require '../../includes/config/database.php';

// Database
    $database = conectarDB();

// Start Session
    $auth = estaAutenticado();

//Write Query
        $query = "SELECT * FROM estado_compra";

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
            <p class="alerta exito">Estado Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Estado Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Estado Eliminado Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/estadocompra/crear.php" class="boton boton-verde">Nuevo Estado</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="representante all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $estado_compra = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $estado_compra['id']; ?> </td>
                        <td>  <?php echo $estado_compra['Tipo_Estado']; ?></td>

                        <td>

                        <form action="" method="POST" class="w-100">
                        <input type="hidden" name="id" value=" <?php echo $estado_compra['id']; ?> " />
                        <label for="btn-confirm" class="boton-rojo-block">Eliminar</label>
                        </form>
                        <a href="/admin/estadocompra/actualizar.php?id=<?php echo $estado_compra['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $estado_compra['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/estadocompra/menureporte.php" class="boton-verde-block">Reporte</a> -->

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