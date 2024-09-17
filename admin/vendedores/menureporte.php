<?php

// Database
require '../../includes/config/database.php';
$database = conectarDB();
require '../../includes/app.php';
// Include Functions And Header
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
        <h1>Crear Reporte en Base al Dinero Recaudado por los Vendedores</h1>
            <a href="/admin/index.php" class="boton boton-verde">Volver</a>

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
            <form class="formulario" method="POST" action="/admin/vendedores/reporte.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>
<!----------  Here end Fieldset  ---------->
                <fieldset>
                            <legend>Informacion Propiedad</legend>

                            <label for="Recaudado">Recaudado</label>
                            <input name="Recaudado" type="number" id="Recaudado" placeholder="Recaudado: Ejemplo: 100" value="<?php ?>" />

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