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
        $consultaVendedores = "SELECT * FROM vendedores WHERE id = {$id}";
        $resultadoConsultaVendedores = mysqli_query($database, $consultaVendedores);
        $vendedores = mysqli_fetch_assoc($resultadoConsultaVendedores);

        $nombre = $vendedores['nombre'];
        $apellido = $vendedores['apellido'];
        $telefono = $vendedores['telefono'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/vendedores/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $nombre = mysqli_real_escape_string( $database, $_POST['Nombre'] );
                $apellido = mysqli_real_escape_string( $database, $_POST['Apellido'] );
                $telefono = mysqli_real_escape_string( $database, $_POST['Telefono'] );

                if(!$nombre)
                {
                    $errores[] = 'Se Debe Agregar Un Nombre';
                }   // Here End If

                if(!$apellido)
                {
                    $errores[] = 'Se Debe Agregar Un Apellido';
                }   // Here End If

                if(!$telefono)
                {
                    $errores[] = 'Se Debe Agregar Un Telefono';
                }   // Here End If
                if(strlen($telefono)<7)
                {
                    $errores[] = 'Numero de Telefono Invalido';
                }   // Here End If


                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE vendedores SET nombre = '{$nombre}', apellido = '{$apellido}', telefono = '{$telefono}' WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/vendedores/index.php?resultado=2');
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
            <a href="/admin/vendedores/index.php" class="boton boton-verde">Volver</a>

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

                        <label for="Nombre">Nombre</label>
                        <input name="Nombre" type="text" id="Categoria" placeholder="Nombre Vendedor" value="<?php echo $nombre; ?>" />

                        <label for="Apellido">Apellido</label>
                        <input name="Apellido" type="text" id="Apellido" placeholder="Apellido Vendedor" value="<?php echo $apellido; ?>" />

                         <label for="Telefono">Telefono</label>
                        <input name="Telefono" type="number" id="Telefono" placeholder="Telefono Vendedor" value="<?php echo $telefono; ?>" />


                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Vendedor</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>