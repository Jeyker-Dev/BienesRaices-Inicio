<?php

    // Include a Template
    require '../../includes/app.php';
    require '../../includes/funciones.php';
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
    $query = "SELECT * FROM propiedades";

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

                    <?php ?>
    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php   if( intval($resultado) === 1): ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php elseif( intval( $resultado) === 2): ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php elseif( intval( $resultado) === 3): ?>
            <p class="alerta exito">Anuncio Eliminado Correctamente</p>
        <?php endif;      ?>
        
            <div class="contenedor-botones">
            <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
            <a href="/admin/propiedades/menureporte.php" class="boton-verde-block">Reporte</a>

            <a href="/admin/" class="boton boton-verde">Volver</a>
            </div>

            <table class="propiedades all">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Habitaciones</th>
                        <th>Baños</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while( $propiedad = mysqli_fetch_assoc( $resultadoConsulta)): ?>
                    <tr>
                        <td> <?php echo $propiedad['id']; ?> </td>
                        <td>  <?php echo $propiedad['titulo']; ?></td>
                        <td> <img src="/imagenes/<?php echo $propiedad['imagen']; ?>.jpg" alt="Imagen Casa" class="imagen-tabla"></td>
                        <td> $ <?php echo $propiedad['precio']; ?></td>
                        <td>  <?php echo $propiedad['habitaciones']; ?></td>
                        <td>  <?php echo $propiedad['wc']; ?></td>
                        <td>

                        <a href="actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-verde-block">Actualizar</a>
                        <a href="eliminar.php?id=<?php echo $propiedad['id']; ?>" class="boton-rojo-block">Eliminar</a>
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