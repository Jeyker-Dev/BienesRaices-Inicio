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

    $ci_representante = '';
    $nombre_repr = '';
    $apellido_repr = '';
    $tlf_repr = '';
    $correo_repr = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $ci_representante = mysqli_real_escape_string( $database, $_POST['CiRepresentante'] );
        $nombre_repr = mysqli_real_escape_string( $database, $_POST['NombreRepr'] );
        $apellido_repr = mysqli_real_escape_string( $database, $_POST['ApellidoRepr'] );
        $tlf_repr = mysqli_real_escape_string( $database, $_POST['TlfRepr'] );
        $correo_repr = mysqli_real_escape_string( $database, $_POST['CorreoRepr'] );

        if(!$ci_representante)
        {
            $errores[] = 'Debe Ingresar Una Cedula del Representante';
        }   // Here End If

        if(strlen($ci_representante)<=6)
        {
            $errores[] = 'Cedula mal escrita';
        }   // Here End If

            
        if(strlen($ci_representante)>8)
        {
            $errores[] = 'Cedula mal escrita';
        }   // Here End If



        if(!$nombre_repr)
        {
            $errores[] = 'Debe Ingresar Un Nombre del Representante';
        }   // Here End If

        if(!$apellido_repr)
        {
            $errores[] = 'Debe Ingresar Un Apellido del Representante';
        }   // Here End If

        if(!$tlf_repr)
        {
            $errores[] = 'Debe Ingresar Un Telefono del Representante';
        }   // Here End If

        if(strlen($tlf_repr)<7)
        {
            $errores[] = 'Numero de Telefono Invalido';
        }   // Here End If



        if(!$correo_repr)
        {
            $errores[] = 'Debe Ingresar Un Correo del Representante';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO representante (Ci_Representante, Nombre_repr, Apellido_repr, Tlf_repre, Correo_repre) 
            VALUES ('{$ci_representante}', '{$nombre_repr}', '{$apellido_repr}', '{$tlf_repr}', '{$correo_repr}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/representante/index.php?resultado=1");
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
            <a href="/admin/representante/index.php" class="boton boton-verde">Volver</a>

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

            <form class="formulario" method="POST" action="/admin/representante/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="CiRepresentante">Ci Representante</label>
                        <input name="CiRepresentante" type="text" id="CiRepresentante" placeholder="Ci Representante" value="<?php echo $ci_representante; ?>" />

                        <label for="NombreRepr"> Nombre </label>
                        <input name="NombreRepr" type="text" id="NombreRepr" placeholder="Nombre Representante" value="<?php echo $nombre_repr; ?>" />

                        <label for="ApellidoRepr"> Apellido </label>
                        <input name="ApellidoRepr" type="text" id="ApellidoRepr" placeholder="Apellido Representante" value="<?php echo $apellido_repr; ?>" />

                        <label for="TlfRepr"> Telefono </label>
                        <input name="TlfRepr" type="text" id="TlfRepr" placeholder="Telefono Representante" value="<?php echo $tlf_repr; ?>" />

                        <label for="CorreoRepr"> Correo </label>
                        <input name="CorreoRepr" type="email" id="CorreoRepr" placeholder="Correo Representante" value="<?php echo $correo_repr; ?>" required/>

                </fieldset>
<!----------  Here end Fieldset  ---------->

                <input type="submit" value="Crear Representante" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>