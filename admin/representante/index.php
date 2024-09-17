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
        $query = "SELECT * FROM representante";

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
            <p class="alerta exito">Representante Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Representante Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Representante Eliminado Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/representante/crear.php" class="boton boton-verde">Nuevo Representante</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="representante all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CI del Representante</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $representante = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $representante['id']; ?> </td>
                        <td>  <?php echo $representante['Ci_Representante']; ?></td>
                        <td>  <?php echo $representante['Nombre_repr']; ?></td>
                        <td>  <?php echo $representante['Apellido_repr']; ?></td>
                        <td>  <?php echo $representante['Tlf_repre']; ?></td>
                        <td>  <?php echo $representante['Correo_repre']; ?></td>
                        <td>

                        <a href="/admin/representante/actualizar.php?id=<?php echo $representante['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $representante['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/representante/menureporte.php" class="boton-verde-block">Reporte</a> -->

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