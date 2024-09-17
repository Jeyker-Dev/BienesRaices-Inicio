<?php
    include './includes/template/header.php';
        
    // Import Conecction
        require './includes/config/database.php';
        $database = conectarDB();

        $id = $_GET['id'];
    
        // Consult 
        $query = "SELECT * FROM propiedades WHERE id = {$id}";
    
        // Get Result
        $resultado = mysqli_query($database, $query);
?>

    <main class="contenedor seccion contenido-centrado">

    <?php
        while( $propiedad = mysqli_fetch_assoc( $resultado ) ):
    ?>

        <h1> <?php echo $propiedad['titulo']; ?> </h1>

            <img src="./imagenes/<?php echo $propiedad['imagen']; ?>.jpg" alt="Imagen Propiedad" loading="lazy">

        <div class="resumen-propiedad">

            <p class="precio"> </p>

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

            <p?>
                <?php echo $propiedad['descripcion']; ?>
            </p>

            <?php
        endwhile;
            ?>

        </div>
<!----------  Here end Resumen Propiedad  ---------->
        <div class="contenedor-boton-propiedad">
            <a href="./anuncios.php" class="boton boton-verde">Volver</a>
        </div>
    </main>
<!----------  Here end Main  ---------->

    <?php
        include './includes/template/footer.php';
    ?>
<!----------  Here end Footer  ---------->