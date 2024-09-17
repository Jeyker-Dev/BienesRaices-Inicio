<?php
    require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
    require '../../includes/config/database.php';

// Database
    $database = conectarDB();
    
// Dialogo
require '../../includes/template/dialogos.php';

// Start Session
    $auth = estaAutenticado();

// Array Errors
    $errores = [];

    // Get Id From Url
    $id = $_GET['id'];

    // Validate Id From Url
    $id = filter_var( $id, FILTER_VALIDATE_INT );

       // Get Data From Categoria
        $consultaTipoPropiedades = "SELECT * FROM tipopropiedad WHERE id = {$id}";
        $resultadoConsultaTipoPropiedades = mysqli_query($database, $consultaTipoPropiedades);
        $tipopropiedad = mysqli_fetch_assoc($resultadoConsultaTipoPropiedades);

        $tipopropiedades = $tipopropiedad['TipoPropiedad'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/tipopropiedad/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $tipopropiedades = mysqli_real_escape_string( $database, $_POST['TipoPropiedad'] );

                if(!$tipopropiedades)
                {
                    $errores[] = 'Se Debe Agregar Un Tipo de Propiedad';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE tipopropiedad SET TipoPropiedad = '{$tipopropiedades}' WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/tipopropiedad/index.php?resultado=2');
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

            <form  id="confirmForm" class="formulario" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="TipoPropiedad">Tipo Propiedad</label>
                        <input name="TipoPropiedad" type="text" id="TipoPropiedad" placeholder="Tipo Propiedad" value="<?php echo $tipopropiedades; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Tipo de Propiedad</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
