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
        $consultaMetodoPago = "SELECT * FROM metodo_pago WHERE id = {$id}";
        $resultadoConsultaMetodoPago = mysqli_query($database, $consultaMetodoPago);
        $metodo_pago = mysqli_fetch_assoc($resultadoConsultaMetodoPago);

        $condicion = $metodo_pago['Condicion'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/metodopago/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $condicion = mysqli_real_escape_string( $database, $_POST['Condicion'] );

                if(!$condicion)
                {
                    $errores[] = 'Se Debe Agregar Un Metodo de Pago';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE metodo_pago SET Condicion = '{$condicion}'
                    WHERE id = {$id};";
                    
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/metodopago/index.php?resultado=2');
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
            <a href="/admin/metodopago/index.php" class="boton boton-verde">Volver</a>

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

                        <label for="Condicion">Metodo de Pago</label>
                        <input name="Condicion" type="text" id="Condicion" placeholder="Metodo Pago" value="<?php echo $condicion; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Metodo</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    
    incluirTemplate('footer');

?>
