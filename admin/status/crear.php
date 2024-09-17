<?php

require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
    require '../../includes/config/database.php';

// Database
    $database = conectarDB();

// Start Session
    $auth = estaAutenticado();

// Array Errors
    $errores = [];

    $tipo_estado = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $tipo_estado = mysqli_real_escape_string( $database, $_POST['Status'] );

        if(!$tipo_estado)
        {
            $errores[] = 'Debe Ingresar Un Tipo de Estado';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO status (Tipo_Estado) VALUES ('{$tipo_estado}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/status/index.php?resultado=1");
            }   // Here End If

        }   // Here End If

            // If Session ain't right go back to index
            if(!$auth)
            {
                header('Location: /');
            }   // Here End If

    }   // Here End If


?>

<!-- Body   -->
<main class="contenedor seccion">
        <h1>Crear</h1>
            <a href="/admin/status/index.php" class="boton boton-verde">Volver</a>

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

            <form class="formulario" method="POST" action="/admin/status/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Status">Status</label>
                        <input name="Status" type="text" id="Status" placeholder="Tipo Estado" value="<?php echo $tipo_estado; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

                <input type="submit" value="Crear Status" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
