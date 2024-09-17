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
    $query = "SELECT * FROM cliente";

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
            <p class="alerta exito">Cliente Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Cliente Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Cliente Eliminado Correctamente</p>
        <?php endif;      ?>
        
            <div class="contenedor-botones">
            <a href="/admin/clientes/crear.php" class="boton boton-verde">Nuevo Cliente</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            </div>

            <table class="clientes all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $cliente = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td>  <?php echo $cliente['id']; ?> </td>
                        <td>  <?php echo $cliente['CI_client']; ?></td>
                        <td>  <?php echo $cliente['Nombre_client']; ?> </td>
                        <td>  <?php echo $cliente['Apellido_client']; ?></td>
                        <td>  <?php echo $cliente['Tlf_client']; ?></td>
                        <td>  <?php echo $cliente['Correo_client']; ?></td>
                        <td>

                        <a href="actualizar.php?id=<?php echo $cliente['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $cliente['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/propiedades/menureporte.php" class="boton-verde-block">Reporte</a> -->
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