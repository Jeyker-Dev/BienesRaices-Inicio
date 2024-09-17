<footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="nosotros.html">Nosotros</a>
                <a href="anuncios.html">Anuncios</a>
                <a href="blog.html">Blog</a>
                <!-- <a href="contacto.html">Contacto</a> -->
            </nav>

            <?php
                $fecha = date('d-m-y');
            ?>
            <p class="copyright">Todos los Derechos Reservados <?php echo $fecha; ?>. &copy</p>
            <p class="copyright">Contactar a: bienesraices@gmail.com </p>

        </div>
    </footer>

    <script src="/src/js/app.js"></script>
    <!----------  Here end Script  ---------->
    <script src="/build/js/bundle.min.js"></script>
<!----------  Here end Script  ---------->
</body>
</html>