<?php
    require '../../includes/app.php';
require '../../includes/funciones.php';

// Include a Template
incluirTemplate('header');

// Import Conecction
    require '../../includes/config/database.php';
    
    // Dialogo
    require '../../includes/template/dialogos.php';

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
        $consultaRepresentantes = "SELECT * FROM representante WHERE id = {$id}";
        $resultadoConsultaRepresentantes = mysqli_query($database, $consultaRepresentantes);
        $representante = mysqli_fetch_assoc($resultadoConsultaRepresentantes);

        $ci_representante = $representante['Ci_Representante'];
        $nombre_repr = $representante['Nombre_repr'];
        $apellido_repr = $representante['Apellido_repr'];
        $tlf_repre = $representante['Tlf_repre'];
        $correo_repre = $representante['Correo_repre'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/representante/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $ci_representante = mysqli_real_escape_string( $database, $_POST['CiRepresentante'] );
                $nombre_repr = mysqli_real_escape_string( $database, $_POST['NombreRepr'] );
                $apellido_repr = mysqli_real_escape_string( $database, $_POST['ApellidoRepr'] );
                $tlf_repre = mysqli_real_escape_string( $database, $_POST['TlfRepre'] );
                $correo_repre = mysqli_real_escape_string( $database, $_POST['CorreoRepre'] );

                if(!$ci_representante)
                {
                    $errores[] = 'Se Debe Agregar Una Cedula';
                }   // Here End If

                if(!$nombre_repr)
                {
                    $errores[] = 'Debe Ingresar Un Nombre del Representante';
                }   // Here End If

                if(!$apellido_repr)
                {
                    $errores[] = 'Debe Ingresar Un Apellido del Representante';
                }   // Here End If

                if(!$tlf_repre)
                {
                    $errores[] = 'Debe Ingresar Un Telefono del Representante';
                }   // Here End If

                if(strlen($tlf_repre)<7)
                {
                    $errores[] = 'Numero de Telefono Invalido';
                }   // Here End If


                if(!$correo_repre)
                {
                    $errores[] = 'Debe Ingresar Un Correo del Representante';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE representante SET Ci_Representante = '{$ci_representante}', Nombre_repr = '{$nombre_repr}', 
                    Apellido_repr = '{$apellido_repr}', Tlf_repre = '{$tlf_repre}' , Correo_repre = '{$correo_repre}'
                    WHERE id = {$id};";
                    
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/representante/index.php?resultado=2');
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

            <form id="confirmForm" class="formulario" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="CiRepresentante">Ci Representante</label>
                        <input name="CiRepresentante" type="text" id="CiRepresentante" placeholder="Ci Representante" value="<?php echo $ci_representante; ?>" />

                        <label for="NombreRepr"> Nombre </label>
                        <input name="NombreRepr" type="text" id="NombreRepr" placeholder="Nombre Representante" value="<?php echo $nombre_repr; ?>" />

                        <label for="ApellidoRepr"> Apellido </label>
                        <input name="ApellidoRepr" type="text" id="ApellidoRepr" placeholder="Apellido Representante" value="<?php echo $apellido_repr; ?>" />

                        <label for="TlfRepre"> Telefono </label>
                        <input name="TlfRepre" type="text" id="TlfRepre" placeholder="Telefono Representante" value="<?php echo $tlf_repre; ?>" />

                        <label for="CorreoRepre"> Correo </label>
                        <input name="CorreoRepre" type="email" id="CorreoRepre" placeholder="Correo Representante" value="<?php echo $correo_repre; ?>" required/>

                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Representante</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
