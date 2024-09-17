<?php

// Import Conecction
    require "includes/config/database.php";
    $database = conectarDB();

    // Include Header
    require 'includes/app.php';
    include 'includes/funciones.php';
    incluirTemplate('header');

    // Array Errors
    $errores = [];

    $email = '';
    $user_password = '';
    $nombre = '';
    $apellido = '';
    $fecha_naci = '';
    $direccion = '';
    $fecha_actual = date('y-m-d');


    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $email = mysqli_real_escape_string($database, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL ) );
        $user_password = mysqli_real_escape_string($database, $_POST['user_password'] );
        $nombre = mysqli_real_escape_string($database, $_POST['Nombre'] );
        $apellido = mysqli_real_escape_string($database, $_POST['Apellido'] );
        $fecha_naci = mysqli_real_escape_string($database, $_POST['FechaNaci'] );
        $direccion = mysqli_real_escape_string($database, $_POST['Direccion'] );

        // Convert Date to Y-M-D
        $fecha_naci = date('y-m-d', strtotime($fecha_naci));

        // Verificar si el email ya está en uso
        $consulta_email = "SELECT COUNT(*) AS total FROM usuarios WHERE email = '$email'";
        $resultado_email = $database->query($consulta_email);
        $fila_email = $resultado_email->fetch_assoc();
        $total_usuarios_con_email = $fila_email['total'];

        if(!$email)
        {
            $errores[] = 'El Email Es Obligatorio o No es Valido';
        }   // Here End If

        if(!$user_password)
        {
            $errores[] = 'El Password Es Obligatorio o NO es Valido';
        }   // Here End If

        if(!$nombre)
        {
            $errores[] = 'El Nombre Es Obligatorio';
        }   // Here End If
        
        if(!$apellido)
        {
            $errores[] = 'El Apellido Es Obligatorio';
        }   // Here End If

        if(!$fecha_naci)
        {
            $errores[] = 'La Fecha de Nacimiento Es Obligatorio';
        }   // Here End If

        if(!$direccion)
        {
            $errores[] = 'La Direccion Es Obligatoria';
        }   // Here End If

        if($fecha_naci > $fecha_actual)
        {
            $errores[] = 'La Fecha de Nacimiento no puede Exceder El Dia Actual';
        }

        if(strlen($user_password)<6)
        {
            $errores[] = 'Contraseña muy corta';
        }   // Here End If

        if ($total_usuarios_con_email > 0) 
        {
            $errores[] = "El email ya está en uso. Por favor, utiliza otro email.";
        }   // Here End If 

        

        if( empty( $errores) )
        {

             // Hash Password
            $passwordHash = password_hash( $user_password, PASSWORD_BCRYPT );

            // Consult to Create User
            $query = "INSERT INTO usuarios (email, user_password, nombre, apellido, fecha_naci, direccion) 
            VALUES ( '{$email}', '{$passwordHash}', '{$nombre}', '{$apellido}', '{$fecha_naci}', '{$direccion}');";

            // Insert To Database
            $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /login.php?resultado=4');
            }   // Here End If
        }   // Here End If

    }   // Here End If
?>

<main class="contenedor seccion">
        <h1>Crear Cuenta</h1>

        
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

        <form class="formulario" method="POST">
            <fieldset>
                    <legend>Email y Password</legend>

                    <label for="account-Button--Email">Email</label>
                    <input name="email" id="account-Button--Email" type="email" placeholder="Tu Email" value="<?php echo $email; ?>" required />

                    <label for="account-Button--Telefono">Password</label>
                    <input name="user_password" id="account-Button--Telefono" type="password" placeholder="Tu Password (minimo 6 caracteres)" required />

                    <label for="account-Button--Nombre">Nombre</label>
                    <input name="Nombre" id="account-Button--Nombre" type="text" placeholder="Tu Nombre" value="<?php echo $nombre; ?>" />

                    <label for="account-Button--Apellido">Apellido</label>
                    <input name="Apellido" id="account-Button--Apellido" type="text" placeholder="Tu Apellido" value="<?php echo $apellido; ?>" />

                    <label for="account-Button--FechaNaci">Fecha Nacimiento</label>
                    <input name="FechaNaci" id="account-Button--FechaNaci" type="date" placeholder="Tu Fecha de Nacimiento" required />

                    <label for="account-Button--Direccion">Direccion</label>
                    <input name="Direccion" id="account-Button--Direccion" type="text" placeholder="Tu Direccion" value="<?php  echo $direccion; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->
            <div class="contenedor-botones">
            <input type="submit" value="Crear Cuenta" class="account-Button--Enviar boton boton-verde">
            <a href="/admin/index.php" class="boton-verde">Volver</a>
            </div>
                
        </form>
<!----------  Here end Form  ---------->

    </main>
<!----------  Here end Main  ---------->