<?php
    include './includes/template/header.php';
?>

    <main class="contenedor seccion">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img src="build/img/destacada3.jpg" alt="Imagen Contacto" loading="lazy">
        </picture>

        <h2>LLene el Formulario de Contacto</h2>

        <form action="" class="formulario">
            <fieldset>
                <legend>Informacion Personal</legend>

                <label for="contact-Button--Nombre">Nombre</label>
                <input id="contact-Button--Nombre" type="text" placeholder="Tu Nombre">

                <label for="contact-Button--Email">Email</label>
                <input id="contact-Button--Email" type="email" placeholder="Tu Email">

                <label for="contact-Button--Telefono">Telefono</label>
                <input id="contact-Button--Telefono" type="tel" placeholder="Tu Telefono">

                <label for="contact-Button--Mensaje">Mensaje</label>
                <textarea id="contact-Button--Mensaje" placeholder="Tu Mensaje"></textarea>
            </fieldset>
<!----------  Here end Fieldset  ---------->
            <fieldset>
                <legend>Informacion Sobre la Propiedad</legend>

                <label for="contact-Select">Vende o Compra</label>
                <select name="" id="contact-Select">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="Compra">Compra</option>
                    <option value="Vende">Vende</option>
                </select>

                <label for="contact-Button--Presupuesto">Precio o Presupuesto</label>
                <input id="contact-Button--Presupuesto" type="number" placeholder="Tu Precio o Presupuesto">
            </fieldset>
<!----------  Here end Fieldset  ---------->
            <fieldset>
                <legend></legend>

                <p>Como Quiere Ser Contactado</p>

                <div class="forma-contacto">
                    <label for="contact-Button-Radio--Telefono">Telefono</label>
                    <input name="contact-Button-Radio" type="radio" value="Telefono" id="contact-Button-Radio--Telefono">

                    <label for="contact-Button-Radio--Email">Email</label>
                    <input name="contact-Button-Radio" type="radio" value="Telefono" id="contact-Button-Radio--Email">
                </div>

                <p>Si Eligio Telefono, Eliga la Fecha y Hora</p>

                <label for="contact-Button-Radio--Fecha">Fecha</label>
                <input type="date" id="contact-Button-Radio--Fecha">

                <label for="contact-Button-Hora">Hora</label>
                <input type="time" id="contact-Button--Telefono">
            </fieldset>

            <input type="submit" value="Enviar" class="contact-Button--Enviar boton-verde">
<!----------  Here end Fieldset  ---------->
        </form>
<!----------  Here end Form Contact  ---------->
    </main>
<!----------  Here end Main  ---------->

    <?php
        incluirTemplate('footer');
    ?>