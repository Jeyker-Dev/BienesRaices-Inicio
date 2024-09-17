<?php
    // Include Header
    require 'includes/app.php';
    include './includes/funciones.php';
    incluirTemplate('header');

    // Connection
    require 'includes/config/database.php';
    $database = conectarDB();

    // Array Errors
    $errores = [];

    // Show Conditional Message
    $resultado = $_GET['resultado'] ?? null;


    // Authenticate User
    if($_SERVER["REQUEST_METHOD"] === 'POST')
    {
        $email = mysqli_real_escape_string($database, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL ) );

        $user_password = mysqli_real_escape_string($database, $_POST['user_password'] );

        if(!$email)
        {
            $errores = ['El Email Es Obligatorio o No es Valido'];
        }   // Here End If

        if(!$user_password)
        {
            $errores = ['El Password Es Obligatorio o NO es Valido'];
        }   // Here End If

        if(empty( $errores ))
        {
            // Check If User Exist
            $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
            $resultado =  mysqli_query($database, $query);

            if($resultado -> num_rows)
            {
                // Check If Password is Correct
                $usuario = mysqli_fetch_assoc( $resultado );

                // Check If Password is Right or Not
                $auth = password_verify( $user_password ,$usuario['user_password']);

                if($auth)
                {
                    // User Is Right
                    session_start();

                    // Fill Array Session
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin/');
                }   // Here End If
                else
                {
                    $errores = ['El Password es Incorrecto'];
                }
            }   // Here end If
            else
            {
                $errores = ['El Usuario no Existe'];
            }   // Here end Else
        }   // Here End If
    }   // Here End If
?>

    <main class="contenedor seccion">
        <h1>Iniciar Sesion</h1>

        <?php
            foreach($errores as $error):
        ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php
            endforeach;
        ?>

        <?php   if( intval($resultado) === 4): ?>
            <p class="alerta exito">Cuenta Creada Correctamente</p>
        <?php endif; ?>

        <form class="formulario" method="POST">
            <fieldset>
                    <legend>Email y Password</legend>

                    <label for="login-Button--Email">Email</label>
                    <input name="email" id="login-Button--Email" type="email" placeholder="Tu Email" required />

                    <label for="login-Button--Telefono">Password</label>
                    <input name="user_password" id="login-Button--Telefono" type="password" placeholder="Tu Password" required />

                </fieldset>
<!----------  Here end Fieldset  ---------->
                <div class="login-inferior">
                <input type="submit" value="Iniciar Sesion" class="login-Button--Enviar boton boton-verde">
                </div>
        </form>
<!----------  Here end Form  ---------->

    </main>
<!----------  Here end Main  ---------->

    <?php
    // Include Footer
    incluirTemplate('footer');
    ?>