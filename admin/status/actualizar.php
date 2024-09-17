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
        $consultaStatus = "SELECT * FROM status WHERE id = {$id}";
        $resultadoConsultaStatus = mysqli_query($database, $consultaStatus);
        $status = mysqli_fetch_assoc($resultadoConsultaStatus);

        $tipo_estado = $status['Tipo_Estado'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/status/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $tipo_estado = mysqli_real_escape_string( $database, $_POST['Status'] );

                if(!$tipo_estado)
                {
                    $errores[] = 'Se Debe Agregar Un Estado';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE status SET Tipo_Estado = '{$tipo_estado}' WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/status/index.php?resultado=2');
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

            <form  id="confirmForm" class="formulario" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Status">Status</label>
                        <input name="Status" type="text" id="Status" placeholder="Tipo Estado" value="<?php echo $tipo_estado; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Status</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
