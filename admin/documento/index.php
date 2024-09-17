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
        $query = "SELECT * FROM documento";

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
            <p class="alerta exito">Documento Creada Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Documento Actualizada Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Documento Eliminada Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/documento/crear.php" class="boton boton-verde">Nueva Documento</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="documento all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo de Propiedad</th>
                        <th>Certificado</th>
                        <th>Impuestos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $documento = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $documento['id']; ?> </td>
                        <td>  <?php echo $documento['Titulo_Propiedad']; ?></td>
                        <td>  <?php echo $documento['Certificado']; ?></td>
                        <td>  <?php echo $documento['Impuestos']; ?></td>
                    <td>

                        <a href="/admin/documento/actualizar.php?id=<?php echo $documento['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $documento['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/documento/reporte.php" class="boton-verde-block">Reporte</a> -->

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