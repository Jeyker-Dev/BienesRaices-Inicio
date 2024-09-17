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
        $consultaClientes = "SELECT * FROM cliente WHERE id = {$id}";
        $resultadoConsultaClientes = mysqli_query($database, $consultaClientes);
        $cliente = mysqli_fetch_assoc($resultadoConsultaClientes);

        $ci_client = $cliente['CI_client'];
        $nombre_client = $cliente['Nombre_client'];
        $apellido_client = $cliente['Apellido_client'];
        $tlf_client = $cliente['Tlf_client'];
        $correo_client = $cliente['Correo_client'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/clientes/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $ci_client = mysqli_real_escape_string( $database, $_POST['Cedula'] );
                $nombre_client = mysqli_real_escape_string( $database, $_POST['Nombre'] );
                $apellido_client = mysqli_real_escape_string( $database, $_POST['Apellido'] );
                $tlf_client = mysqli_real_escape_string( $database, $_POST['Telefono'] );
                $correo_client = mysqli_real_escape_string( $database, $_POST['Correo'] );

                if(!$ci_client)
                {
                    $errores[] = 'Se Debe Agregar Una Cedula';
                }   // Here End If

                if(!$nombre_client)
                {
                    $errores[] = 'Debe Ingresar Un Nombre';
                }   // Here End If

                if(!$apellido_client)
                {
                    $errores[] = 'Debe Ingresar Un Apellido';
                }   // Here End If

                if(!$tlf_client)
                {
                    $errores[] = 'Debe Ingresar Un Telefono';
                }   // Here End If

                
                if(strlen($tlf_client)<7)
                {
                    $errores[] = 'Numero de Telefono Invalido';
                }   // Here End If

                if(!$correo_client)
                {
                    $errores[] = 'Debe Ingresar Un Correo';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE cliente SET CI_client = '{$ci_client}', Nombre_client = '{$nombre_client}', 
                    Apellido_client = '{$apellido_client}', Tlf_client = '{$tlf_client}' , Correo_client = '{$correo_client}'
                    WHERE id = {$id};";
                    
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/clientes/index.php?resultado=2');
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
            <a href="/admin/clientes/index.php" class="boton boton-verde">Volver</a>

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

                        <label for="Cedula">Cedula Cliente</label>
                        <input name="Cedula" type="number" id="Cedula" placeholder="Cedula" value="<?php echo $ci_client; ?>" />

                        <label for="Nombre"> Nombre Cliente</label>
                        <input name="Nombre" type="text" id="Nombre" placeholder="Nombre" value="<?php echo $nombre_client; ?>" />

                        <label for="Apellido"> Apellido </label>
                        <input name="Apellido" type="text" id="Apellido" placeholder="Apellido" value="<?php echo $apellido_client; ?>" />

                        <label for="Telefono"> Telefono </label>
                        <input name="Telefono" type="text" id="Telefono" placeholder="Telefono" value="<?php echo $tlf_client; ?>" />

                        <label for="Correo"> Correo </label>
                        <input name="Correo" type="email" id="Correo" placeholder="Correo" value="<?php echo $correo_client; ?>" required />

                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Cliente</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
