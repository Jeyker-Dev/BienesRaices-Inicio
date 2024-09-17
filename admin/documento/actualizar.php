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

       // Get Data From Documento
        $consultaDocumento = "SELECT * FROM documento WHERE id = {$id}";
        $resultadoConsultaDocumento = mysqli_query($database, $consultaDocumento);
        $documento = mysqli_fetch_assoc($resultadoConsultaDocumento);

        $titulo_propiedad = $documento['Titulo_Propiedad'];
        $certificado = $documento['Certificado'];
        $impuestos = $documento['Impuestos'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/documento/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $titulo_propiedad = mysqli_real_escape_string( $database, $_POST['Titulo'] );
                $certificado = mysqli_real_escape_string( $database, $_POST['Certificado'] );
                $impuestos = mysqli_real_escape_string( $database, $_POST['Impuestos'] );

                if(!$titulo_propiedad)
                {
                    $errores[] = 'Se Debe Agregar Un Titulo De Propiedad';
                }   // Here End If

                if(!$certificado)
                {
                    $errores[] = 'Se Debe Agregar Un Certificado';
                }   // Here End If

                if(!$impuestos)
                {
                    $errores[] = 'Se Debe Agregar Un Impuesto';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE documento SET Titulo_Propiedad = '{$titulo_propiedad}', Certificado = '{$certificado}', Impuestos = '{$impuestos}' WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/documento/index.php?resultado=2');
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

            <form id="confirmForm" class="formulario" method="POST" enctype="multipart/form-data">
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

               <label for="btn-confirm" class="boton boton-verde">Actualizar Documento</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
