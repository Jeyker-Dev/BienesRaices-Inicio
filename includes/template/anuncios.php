<?php
    // Import Conecction
    require __DIR__ . '/../config/database.php';
    $database = conectarDB();

    // Consult 
    $query = "SELECT * FROM propiedades LIMIT {$limite}";

    // Get Result
    $resultado = mysqli_query($database, $query);
?>

<div class="contenedor-anuncios">

    <?php
        while( $propiedad = mysqli_fetch_assoc( $resultado ) ):
    ?>

            <div class="anuncio">

                <img class="anuncio-imagen" src="/imagenes/<?php echo $propiedad['imagen']; ?>.jpg" alt="anuncio" loading="lazy">

                <div class="contenido-anuncio">
                    <h3> <?php echo $propiedad['titulo']; ?> </h3>
                    <p> <?php echo $propiedad['descripcion']; ?> </p>
                    <p class="precio"> <?php echo $propiedad['precio']; ?> </p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono Baño">
                            <p> <?php echo $propiedad['wc']; ?> </p>
                        </li>

                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                            <p> <?php echo $propiedad['estacionamiento']; ?> </p>
                        </li>

                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                            <p> <?php echo $propiedad['habitaciones']; ?> </p>
                        </li>
                    </ul>

                    <a href="../../anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div>
<!----------  Here end Contenido Anuncio  ---------->
            </div>
<!----------  Here end Anuncio  ---------->

            <?php
                endwhile;
            ?>

        </div>
<!----------  Here end Contenedor Anuncios  ---------->

<?php
    // Close Conecction
    mysqli_close($database);
?>