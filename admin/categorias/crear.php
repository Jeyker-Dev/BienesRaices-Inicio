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

    $categoria_propiedad = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $categoria_propiedad = mysqli_real_escape_string( $database, $_POST['Categoria'] );

        if(!$categoria_propiedad)
        {
            $errores[] = 'Debe Ingresar Una Categoria';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO categoria (Categoria_Propiedad) VALUES ('{$categoria_propiedad}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/categorias/index.php?resultado=1");
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
            <a href="/admin/categorias/index.php" class="boton boton-verde">Volver</a>

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

            <form class="formulario" method="POST" action="/admin/categorias/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Categoria">Categoria</label>
                        <input name="Categoria" type="text" id="Categoria" placeholder="Categoria Propiedad" value="<?php echo $categoria_propiedad; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

                <input type="submit" value="Crear Categoria" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>