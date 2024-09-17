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
        $query = "SELECT s.id, s.Fecha, s.Client_CI, p.titulo AS TituloPropiedad, s.Propiedades_Id, e.Tipo_Estado AS TipoEstado
                FROM solicitud_compra s
                INNER JOIN propiedades p ON s.Propiedades_Id = p.id
                INNER JOIN estado_compra e ON s.Estado_Id = e.id";

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
            <p class="alerta exito">Solicitud Creada Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Solicitud Actualizada Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Solicitud Eliminada Correctamente</p>
        <?php endif;      ?>
            
        <div class="contenedor-botones">
            <a href="/admin/solicitudcompra/crear.php" class="boton boton-verde">Nueva Solicitud</a>
            <a href="/admin/" class="boton boton-verde">Volver</a>
            
        </div>

            <table class="representante all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cedula Cliente</th>
                        <th>Propiedades ID</th>
                        <th>Estado ID</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $solicitudcompra = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $solicitudcompra['id']; ?> </td>
                        <td> <?php echo $solicitudcompra['Fecha']; ?> </td>
                        <td> <?php echo $solicitudcompra['Client_CI']; ?> </td>
                        <td> <?php echo $solicitudcompra['TituloPropiedad']; ?> </td>
                        <td> <?php echo $solicitudcompra['TipoEstado']; ?> </td>
                        <td>

                        <a href="/admin/solicitudcompra/actualizar.php?id=<?php echo $solicitudcompra['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $solicitudcompra['id']; ?>" class="boton-rojo-block">Eliminar</a>
                        <!-- <a href="/admin/solicitudcompra/menureporte.php" class="boton-verde-block">Reporte</a> -->

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