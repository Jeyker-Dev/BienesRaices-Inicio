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
        $query = "SELECT * FROM tipopropiedad";

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
            <p class="alerta exito">Tipo Propiedad Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Tipo Propiedad Actualizada Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Tipo Propiedad Eliminada Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/tipopropiedad/crear.php" class="boton boton-verde">Nuevo Tipo Propiedad</a>
                        <a href="/admin/tipopropiedad/menureporte.php" class="boton-verde-block">Reporte</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>

        </div>

            <table class="categoria all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo Propiedad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $tipopropiedad = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $tipopropiedad['id']; ?> </td>
                        <td>  <?php echo $tipopropiedad['TipoPropiedad']; ?></td>
                        <td>

                        <form action="" method="POST" class="w-100">
                        <input type="hidden" name="id" value=" <?php echo $tipopropiedad['id']; ?> " />
                        <label for="btn-confirm" class="boton-rojo-block">Eliminar</label>
                        </form>
                        <a href="/admin/tipopropiedad/actualizar.php?id=<?php echo $tipopropiedad['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <!-- <a href="eliminar.php?id=<?php echo $categoria['id']; ?>" class="boton-rojo-block">Eliminar</a> -->

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