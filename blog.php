<?php
    include './includes/template/header.php';
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="iamge/jpeg">
                    <img src="build/img/blog1.jpg" alt="Imagen Entrada" loading="lazy">
                </picture>
            </div>
<!----------  Here end Imagen  ---------->
            <div class="texto-entrada">
                <a href="./entrada.php">
                    <h4>Terraza en el Techo de Tu Casa</h4>
                        <p class="informacion-meta">Escrito el: <span>8/01/2024</span> Por: <span>Admin</span></p>

                        <p>Consejos para Construir una Terraza en el Techo de tu Casa</p>
                </a>
            </div>
<!----------  Here end Texto Entrada  ---------->
        </article>
<!----------  Here end Article  ---------->
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="iamge/jpeg">
                    <img src="build/img/blog2.jpg" alt="Imagen Entrada" loading="lazy">
                </picture>
            </div>
<!----------  Here end Imagen  ---------->
            <div class="texto-entrada">
                <a href="./entrada.php">
                    <h4>Guia para la Decoracion de tu Casa</h4>
                        <p class="informacion-meta">Escrito el: <span>8/01/2024</span> Por: <span>Admin</span></p>

                        <p>Maximiza el Espacio de tu Casa con Esta Guia</p>
                </a>
            </div>
<!----------  Here end Texto Entrada  ---------->
        </article>
<!----------  Here end Article  ---------->
    </main>
<!----------  Here end Main  ---------->

    <?php
        incluirTemplate('footer');
    ?>