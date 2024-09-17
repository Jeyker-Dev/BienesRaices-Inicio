<?php
        include './includes/template/header.php';
?>

    <main class="contenedor seccion">
        <h1>Conoce Sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                    <img src="build/img/nosotros.jpg" alt="Sobre Nosotros" loading="lazy">
                </picture>
            </div>
<!----------  Here end Contenido-Nosotros  ---------->
            <div class="texto-nosotros">
                <blockquote>
                    10 Años de Experiencia
                </blockquote>

                <p>
                ¡Bienvenido a nuestra página de bienes raíces! Con más de una década de experiencia en el apasionante mundo de la compra y venta de propiedades, nos enorgullece ser tus guías en este emocionante viaje hacia encontrar tu hogar ideal. Durante estos 10 años, hemos perfeccionado nuestras habilidades para entender tus necesidades, ofrecerte las mejores opciones del mercado y acompañarte en cada paso del proceso. Confía en nuestro equipo experto para hacer de tu búsqueda de vivienda una experiencia sin complicaciones. ¡Déjanos ayudarte a encontrar el lugar perfecto para ti!"
                </p>
            </div>
<!----------  Here end Texto-Nosotros  ---------->
        </div>
<!----------  Here end Contenedor Seccion ---------->
    </main>
<!----------  Here end Main  ---------->
        <section class="contenedor seccion">
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

                <div class="icono">
                    <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
                    <h3>Tiempo</h3>
                    <p>
                    Nos destacamos por nuestra eficacia al buscar propiedades que se ajusten a tus preferencias. Con nuestro sistema avanzado de filtrado y clasificación, podrás encontrar rápidamente lo que buscas. Ya sea que prefieras una ubicación específica, un tipo de propiedad en particular o ciertas características, nuestra plataforma te proporcionará resultados precisos en tiempo récord. Ahorra tiempo y esfuerzo con nosotros y encuentra tu hogar ideal de manera eficiente.
                    </p>
                </div>

            </div>
<!----------  Here end Iconos Nosotros  ---------->
</section>
<!----------  Here end Main  ---------->

    <?php
        incluirTemplate('footer');
    ?>

    <script src="build/js/bundle.min.js"></script>
<!----------  Here end Script  ---------->
</body>
</html>