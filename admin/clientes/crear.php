<?php

    // Database
    require '../../includes/config/database.php';
    $database = conectarDB();

    // Include Functions And Header
    require '../../includes/app.php';
    require '../../includes/funciones.php';
    incluirTemplate('header');

    // Start Session
    $auth = estaAutenticado();

    // Query to See data from Clients
    $consultaCliente  = "SELECT * FROM cliente";
    $resultadoCliente = mysqli_query($database, $consultaCliente);

    // Array Errors
    $errores = [];

    $ci_client = '';
    $nombre_client = '';
    $apellido_client = '';
    $tlf_client = '';
    $correo_client = '';

    // Run Code After Admin Send Form and Save In Database
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        /*
        $_POST // To See Information When Data is Send
            var_dump($_POST);

        $_FILES // To See Information of Archives, for example an Image
            var_dump($$_FILES);
        */

        $ci_client = mysqli_real_escape_string( $database, $_POST['Cedula'] );
        $nombre_client = mysqli_real_escape_string( $database, $_POST['Nombre'] );
        $apellido_client = mysqli_real_escape_string( $database, $_POST['Apellido'] );
        $tlf_client = mysqli_real_escape_string( $database, $_POST['Telefono'] );
        $correo_client = mysqli_real_escape_string( $database, $_POST['Correo'] );

        if($ci_client === '')
        {
            $errores[] = 'Debes Agregar una Cedula';
        }   // Here End IF

        if($nombre_client === '')
        {
            $errores[] = 'Debes Agregar un Nombre';
        }   // Here End IF

        if(!$apellido_client)
        {
            $errores[] = 'El Apellido es Obligatorio';
        }   // Here End IF

        if(!$tlf_client)
        {
            $errores[] = 'El Telefono Es Obligatorio';
        }   // Here End IF

        if(strlen($tlf_client)<7)
        {
            $errores[] = 'Numero de Telefono Invalido';
        }   // Here End If


        if(!$correo_client)
        {
            $errores[] = 'El  Es Obligatorio';
        }   // Here End IF

        // Look if Array Errors is Empty and Then Run Code
        if(empty( $errores ))
        {

        // Insert in Database
        $query = " INSERT INTO cliente ( CI_client, Nombre_client, Apellido_client, Tlf_client, Correo_client) 
        VALUES ( '$ci_client', '$nombre_client', '$apellido_client' ,'$tlf_client', '$correo_client');";

        $resultado = mysqli_query($database, $query);

        // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/clientes/?resultado=1');
            }   // Here End If

        }   // Here End If
    }   // Here End If

    // If Session ain't right go back to index
    if(!$auth)
    {
        header('Location: /');
    }   // Here End If

?>

<!-- Body   -->
    <main class="contenedor seccion">
        <h1>Crear Cliente</h1>
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

            <form class="formulario" method="POST" action="/admin/clientes/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Cedula">Cedula</label>
                        <input name="Cedula" type="number" id="Cedula" placeholder="Cedula" value="<?php echo $ci_client; ?>" />

                        <label for="Nombre">Nombre</label>
                        <input name="Nombre" type="text" id="Nombre" placeholder="Nombre" value="<?php echo $nombre_client; ?>" />

                        <label for="Apellido">Apellido</label>
                        <input name="Apellido" type="text" id="Apellido" placeholder="Apellido" value="<?php echo $apellido_client; ?>" />

                        <label for="Telfono">Telefono</label>
                        <input name="Telefono" type="number" id="Cedula" placeholder="Telefono" value="<?php echo $tlf_client; ?>" />

                        <label for="Correo">Correo</label>
                        <input name="Correo" type="email" id="Correo" placeholder="Correo" value="<?php echo $correo_client; ?>" required/>
                </fieldset>

                <input type="submit" value="Crear Cliente" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->
<?php
    // Include Footer
    incluirTemplate('footer');

?>