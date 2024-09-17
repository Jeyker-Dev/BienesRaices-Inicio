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

    $tipopropiedad = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $tipopropiedad = mysqli_real_escape_string( $database, $_POST['TipoPropiedad'] );

        if(!$tipopropiedad)
        {
            $errores[] = 'Debe Ingresar Un Tipo de la Propiedad';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO tipopropiedad (TipoPropiedad) VALUES ('{$tipopropiedad}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/tipopropiedad/index.php?resultado=1");
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
            <a href="/admin/tipopropiedad/index.php" class="boton boton-verde">Volver</a>

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

            <form class="formulario" method="POST" action="/admin/tipopropiedad/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="TipoPropiedad">Tipo de Propiedad</label>
                        <input name="TipoPropiedad" type="text" id="TipoPropiedad" placeholder="Tipo Propiedad" value="<?php echo $tipopropiedad; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

                <input type="submit" value="Crear Tipo de Propiedad" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>