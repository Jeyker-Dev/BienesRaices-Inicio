<?php
// If Session isn't started then start
if (!isset($_SESSION)) {
    session_start();
}   // Here End If

$auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../../build/css/app.css">
    <img loading="lazy" width="" height="" src="" alt="">
    </picture>

    <script src="/src/js/app.js"></script>
</head>

<body>

    <header class="header <?php echo $inicio ?  'inicio' : ''; ?>">
        <style>
            .header {
                background-image: url(/src/img/header.jpg);
            }
        </style>
        <div class="contenedor contenido-header">

            <div class="barra">
                <a href="/">
                    <img src="../../build/img/logo.svg" alt="Imagen Logo">
                </a>
                <!----------  Here end Logo  ---------->
                <div class="mobile-menu">
                    <img src="../../build/img/barras.svg" alt="Icono Menu Responsive">
                </div>
                <!----------  Here end Mobile Menu  ---------->
                <div class="derecha">
                    <script>
                        function darkMode() {
                            const botonDarkMode = document.querySelector('.dark-mode-boton');

                            botonDarkMode.addEventListener('click', function() {
                                document.body.classList.toggle('dark-mode');
                            }); // Here end Event

                        } // Here End Function
                    </script>
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg" alt="Boton Dark-Mode" onclick="llamar()" />

                    <nav class="navegacion">
                        <a href="../../nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <?php if (!$auth) : ?>
                            <a href="login.php">Login</a>
                        <?php endif;  ?>
                        <?php if ($auth) : ?>
                            <a href="/admin/index.php">Administrar</a>
                            <a href="/estadisticas.php">Estadisticas</a>
                            <a href="/cerrar-sesion.php">Cerrar Sesion</a>
                        <?php endif;  ?>
                    </nav>
                    <!----------  Here end Navegacion  ---------->
                </div>
                <!----------  Here end Derecha  ---------->
            </div>
            <!----------  Here end Barra  ---------->
            <?php
            if ($inicio) {
            ?>
                <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php } ?>
        </div>
        <!----------  Here end Contenido-Header  ---------->
    </header>
    <!----------  Here end Header  ---------->