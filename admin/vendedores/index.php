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
    $query = "SELECT * FROM vendedores";

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
            <p class="alerta exito">Vendedor Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Vendedor Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Vendedor Eliminado Correctamente</p>
        <?php endif;      ?>
        
        <div class="contenedor-botones">
            <a href="/admin/vendedores/crear.php" class="boton boton-verde">Nuevo Vendedor</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
        </div>

            <table class="vendedores all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $vendedor = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $vendedor['id']; ?> </td>
                        <td>  <?php echo $vendedor['nombre']; ?></td>
                        <td>  <?php echo $vendedor['apellido']; ?></td>
                        <td>  <?php echo $vendedor['telefono']; ?></td>
                        <td>

                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $categoria['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/vendedores/menureporte.php" class="boton-verde-block">Reporte</a> -->

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