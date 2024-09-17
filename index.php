<?php

    declare(strict_types = 1);
    require 'includes/app.php';
    require 'includes/funciones.php';

    incluirTemplate('header', $inicio = true);

    
?>
    <main class="contenedor seccion">
        <h1>Mas Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>
                    Tu seguridad es nuestra prioridad. Utilizamos tecnología avanzada para proteger tus datos personales y financieros mientras navegas en nuestro sitio. Puedes confiar en que tu información está segura con nosotros. ¡Gracias por elegirnos para encontrar tu próximo hogar!

                </p>
            </div>
<!----------  Here end Icono Seguridad  ---------->
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>
                      Te ofrecemos accesibilidad con respecto a los precios con nuestros servicios estos  están diseñados para ser accesibles a todos, con opciones de escalabilidad para satisfacer tus necesidades cambiantes. Además, te brindamos soluciones económicas sin comprometer la calidad. ¡Encuentra tu hogar ideal sin preocuparte por el precio en nuestra plataforma confiable!

                </p>
            </div>
<!----------  Here end Icono Precio  ---------->
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>Tiempo</h3>
                <p>
                Nos destacamos por nuestra eficacia al buscar propiedades que se ajusten a tus preferencias. Con nuestro sistema avanzado de filtrado y clasificación, podrás encontrar rápidamente lo que buscas. Ya sea que prefieras una ubicación específica, un tipo de propiedad en particular o ciertas características, nuestra plataforma te proporcionará resultados precisos en tiempo récord. Ahorra tiempo y esfuerzo con nosotros y encuentra tu hogar ideal de manera eficiente.
                </p>
            </div>
<!----------  Here end Icono Tiempo  ---------->
        </div>
<!----------  Here end Iconos Nosotros  ---------->
    </main>
<!----------  Here end Main  ---------->
    <section class="contenedor seccion">
        <h2>Casas y Depas en Venta</h2>

        <?php
        $limite = 3;
        include './includes/template/anuncios.php';
        ?>

        <div class="ver-todas">
            <a href="./anuncios.php" class="boton-verde">Ver Todas</a>
        </div>
<!----------  Here end Ver Todas  ---------->
    </section>
<!----------  Here end Section  ---------->
  
<!----------  Here end Section  ---------->
    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h2>Nuestro Blog</h2>

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
                    <a href="./blog.php">
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
                    <a href="./blog.php">
                        <h4>Guia para la Decoracion de tu Casa</h4>
                            <p class="informacion-meta">Escrito el: <span>8/01/2024</span> Por: <span>Admin</span></p>

                            <p>Maximiza el Espacio de tu Casa con Esta Guia</p>
                    </a>
                </div>
<!----------  Here end Texto Entrada  ---------->
            </article>
<!----------  Here end Article  ---------->
        </section>
<!----------  Here end Section  ---------->
        <section class="testimoniales">
            <h3>Testimoniales</h3>

            <div class="testimonial">
                <blockquote>
                    El Personal se Comporto de una Excelente Forma, muy Buena Atencion y La Casa Cumple Las Expectativas.
                </blockquote>
                <p>- Jeyker Mendoza</p>
            </div>
        </section>
<!----------  Here end Section  ---------->
    </div>
<!----------  Here end Contenedor Seccion  ---------->
    <?php
    incluirTemplate('footer');
    ?>