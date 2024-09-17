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

    $nombre = '';
    $apellido = '';
    $telefono = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $nombre = mysqli_real_escape_string( $database, $_POST['Nombre'] );
        $apellido = mysqli_real_escape_string( $database, $_POST['Apellido'] );
        $telefono = mysqli_real_escape_string( $database, $_POST['Telefono'] );

        if(!$nombre)
        {
            $errores[] = 'Debe Ingresar Un Nombre';
        }   // Here End If

        if(!$apellido)
        {
            $errores[] = 'Debe Ingresar Un Apellido';
        }   // Here End If

        if(!$telefono)
        {
            $errores[] = 'Debe Ingresar Un Telefono';
        }   // Here End If
        
        if(strlen($telefono)<7)
        {
            $errores[] = 'Numero de Telefono Invalido';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO vendedores ( nombre, apellido, telefono) VALUES ('{$nombre}', '{$apellido}', '{$telefono}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/vendedores/index.php?resultado=1");
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

            <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
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

<input type="submit" value="Crear Vendedor" class="boton boton-verde" />

<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>