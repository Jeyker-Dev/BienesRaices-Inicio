<?php
    include './includes/template/header.php';
?>


<main class="contenedor seccion">
            <h2>Casas y Depas en Venta</h2>

            <?php
        $limite = 10;
            include './includes/template/anuncios.php';

            ?>

</main>
<!----------  Here end Main  ---------->



    <?php
        incluirTemplate('footer');
    ?>
<!----------  Here end Footer  ---------->