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

    $titulo_propiedad = '';
    $certificado = '';
    $impuestos = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $titulo_propiedad = mysqli_real_escape_string( $database, $_POST['Titulo'] );
        $certificado = mysqli_real_escape_string( $database, $_POST['Certificado'] );
        $impuestos = mysqli_real_escape_string( $database, $_POST['Impuestos'] );

        if(!$titulo_propiedad)
        {
            $errores[] = 'Debe Ingresar Un Titulo de Propiedad';
        }   // Here End If
        if(!$certificado)
        {
            $errores[] = 'Debe Ingresar Un Certificado';
        }   // Here End If
        if(!$impuestos)
        {
            $errores[] = 'Debe Ingresar Un Impuesto';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO documento (Titulo_Propiedad, Certificado, Impuestos) VALUES ('{$titulo_propiedad}','{$certificado}','{$impuestos}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/documento/index.php?resultado=1");
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
            <a href="/admin/documento/index.php" class="boton boton-verde">Volver</a>

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

            <form class="formulario" method="POST" action="/admin/documento/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Documento">Titulo de Propiedad</label>
                        <input name="Titulo" type="text" id="Titulo Propiedad" placeholder="Titulo Propiedad" value="<?php echo $titulo_propiedad; ?>" />

                        <label for="Documento">Certificado</label>
                        <input name="Certificado" type="text" id="Certificado" placeholder="Certificado" value="<?php echo $certificado; ?>" />

                        <label for="Documento">Impuestos</label>
                        <input name="Impuestos" type="number" id="Impuestos" placeholder="Impuestos" value="<?php echo $impuestos; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

                <input type="submit" value="Crear Documento" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>