<?php

require '../includes/app.php';
require '../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
require '../includes/config/database.php';

// Database
$database = conectarDB();

// Start Session
$auth = estaAutenticado();

?>

<main class="contenedor seccion">

    <div class="menu-crud">
        <a href="./propiedades/" class="enlace-crud">Propiedades</a>
        <a href="./categorias/" class="enlace-crud">Categorias</a>
        <a href="./representante/" class="enlace-crud">Representantes</a>
        <a href="./status/" class="enlace-crud">Status</a>
        <a href="./tipopropiedad/" class="enlace-crud">Tipo Propiedad</a>
        <a href="./vendedores/" class="enlace-crud">Vendedores</a>
        <a href="./clientes/" class="enlace-crud">Clientes</a>
        <a href="./solicitudcompra/" class="enlace-crud">Solicitud Compra</a>
        <a href="./metodopago/" class="enlace-crud">Metodo Pago</a>
        <a href="./estadocompra/" class="enlace-crud">Estado Compra</a>
        <a href="./documento/" class="enlace-crud">Documento</a>
        <a href="./factura/" class="enlace-crud">Factura</a>
        <a href="./gestioncompra/" class="enlace-crud">Gestion Compra</a>
        <a href="../usuario.php" class="enlace-crud">Crear Cuenta</a>
    </div>

</main>


<?php
    // Close Conecction
    mysqli_close($database);
    incluirTemplate('footer');

?>