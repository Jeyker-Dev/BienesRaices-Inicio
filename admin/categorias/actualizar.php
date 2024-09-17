<?php
    require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Dialogo
require '../../includes/template/dialogos.php';

// Import Conecction
    require '../../includes/config/database.php';

// Database
    $database = conectarDB();

// Start Session
    $auth = estaAutenticado();

// Array Errors
    $errores = [];

    // Get Id From Url
    $id = $_GET['id'];

    // Validate Id From Url
    $id = filter_var( $id, FILTER_VALIDATE_INT );

       // Get Data From Categoria
        $consultaCategorias = "SELECT * FROM categoria WHERE id = {$id}";
        $resultadoConsultaCategorias = mysqli_query($database, $consultaCategorias);
        $categoria = mysqli_fetch_assoc($resultadoConsultaCategorias);

        $categoria_propiedad = $categoria['Categoria_Propiedad'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/categorias/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $categoria_propiedad = mysqli_real_escape_string( $database, $_POST['Categoria'] );

                if(!$categoria_propiedad)
                {
                    $errores[] = 'Se Debe Agregar Una Categoria';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE categoria SET Categoria_Propiedad = '{$categoria_propiedad}' WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/categorias/index.php?resultado=2');
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
        <h1>Actualizar</h1>
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

            <form id="confirmForm" class="formulario" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Categoria">Categoria</label>
                        <input name="Categoria" type="text" id="Categoria" placeholder="Categoria Propiedad" value="<?php echo $categoria_propiedad; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Categoria</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
