<?php

// Database
require '../../includes/config/database.php';
$database = conectarDB();

// Include Functions And Header
require '../../includes/app.php';
require '../../includes/funciones.php';
incluirTemplate('header');

// Start Session
$auth = estaAutenticado();

    // Query to See data from Sellers
    $consulta  = "SELECT * FROM vendedores";
    $resultado = mysqli_query($database, $consulta);
    
    // Query to See data from Properties Type
    $consultaTipopropiedad = "SELECT * FROM tipopropiedad";
    $resultadoTipopropiedad = mysqli_query($database, $consultaTipopropiedad);

    // Query to See data from Status
    $consultaStatus = "SELECT * FROM status";
    $resultadoStatus = mysqli_query($database, $consultaStatus);

    // Query to See data from Representantes
    $consultaRepresentantes = "SELECT * FROM representante";
    $resultadoRepresentantes = mysqli_query($database, $consultaRepresentantes);

    // Query to See data from Properties Type
    $consultaCategorias = "SELECT * FROM categoria";
    $resultadoCategorias = mysqli_query($database, $consultaCategorias);

    // Array Errors
    $errores = [];



   // If Session ain't right go back to index
    if(!$auth)
    {
        header('Location: /');
    }   // Here End If

?>

<!-- Body   -->
<main class="contenedor seccion">
        <h1>Crear Reporte en Base a las Caracteristicas de la Vivienda</h1>
            <a href="/admin/propiedades/" class="boton boton-verde">Volver</a>

            <?php
            // Read Array Errors
            foreach($errores as $error):
            ?>

            <div class="alerta error">
                <?php echo $error ?>
            </div>

            <?php
            endforeach;
            ?>
            <form class="formulario" method="POST" action="/admin/propiedades/reporte.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>
                        <label for="Precio">Precio Mayor a ($)</label>
                        <input name="Precio" type="number" id="Precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>" />
<!----------  Here end Fieldset  ---------->
                <fieldset>
                            <legend>Informacion Propiedad</legend>

                            <label for="Habitaciones">Habitaciones</label>
                            <input name="Habitaciones" type="number" id="Habitaciones" placeholder="Habitaciones: Ejemplo: 4" min="1" max="15" value="<?php echo $habitaciones; ?>" />

                            <label for="Baños">Baños</label>
                            <input name="Wc" type="number" id="Baños" placeholder="Baños: Ejemplo: 4" min="1" max="10" value="<?php echo $wc; ?>" />

                            <label for="Estacionamiento">Estacionamiento</label>
                            <input name="Estacionamiento" type="number" id="Estacionamiento" placeholder="Estacionamiento: Ejemplo: 4" min="1" max="50" value="<?php echo $estacionamiento; ?>" />

                </fieldset>
<!----------  Here end FieldSet  ---------->

                <fieldset>
                            <legend>Fechas</legend>

                            <label for="FechaInicio">Fecha Inicio</label>
                            <input name="FechaInicio" type="date" id="FechaInicio" />

                            <label for="FechaFin">Fecha Fin</label>
                            <input name="FechaFin" type="date" id="FechaFin" />

                </fieldset>
<!----------  Here end FieldSet  ---------->

                <input type="submit" value="Crear Reporte" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->


<?php
    // Include Footer
    incluirTemplate('footer');

?>