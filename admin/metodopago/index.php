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
        $query = "SELECT * FROM metodo_pago";

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
            <p class="alerta exito">Metodo Pago Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Metodo Pago Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Metodo Pago Eliminado Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/metodopago/crear.php" class="boton boton-verde">Nuevo Metodo</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Condicion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $metodo_pago = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $metodo_pago['id']; ?> </td>
                        <td>  <?php echo $metodo_pago['Condicion']; ?></td>

                        <td>

                        <a href="/admin/metodopago/actualizar.php?id=<?php echo $metodo_pago['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $metodo_pago['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/metodopago/menureporte.php" class="boton-verde-block">Reporte</a> -->

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