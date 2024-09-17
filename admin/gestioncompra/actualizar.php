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

    
    // Query to See data from Solicitud Compra
    $consulta_solicitud_compra  = "SELECT * FROM solicitud_compra";
    $resultado_solicitud_compra = mysqli_query($database, $consulta_solicitud_compra);

    // Query to See data from Metodo Pago
    $consulta_metodo_pago  = "SELECT * FROM metodo_pago";
    $resultado_metodo_pago = mysqli_query($database, $consulta_metodo_pago);

    // Get Data From gestioncompra
    $consultaGestionCompra = "SELECT * FROM gestioncompra WHERE id = {$id}";
    $resultadoConsultaGestionCompra = mysqli_query($database, $consultaGestionCompra);
    
    $gestion_compra = mysqli_fetch_assoc($resultadoConsultaGestionCompra);

        $monto_final = $gestion_compra['Monto_Final'];
        $solicitud_compra_id = $gestion_compra['Solicitud_Compra_Id'];
        $metodopago_id = $gestion_compra['MetodoPago_Id'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/gestioncompra/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $monto_final = mysqli_real_escape_string( $database, $_POST['MontoFinal'] );

                if(!$monto_final)
                {
                    $errores[] = 'Se Debe Agregar Un Monto';
                }   // Here End If

            if(!$solicitud_compra_id)
            {
                $errores[] = 'Debes Seleccionar Una Solicitud';
            }   // Here End If

            if(!$metodopago_id)
            {
                $errores[] = 'Debes Seleccionar Un Metodo';
            }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE gestioncompra SET Monto_Final = '{$monto_final}', Solicitud_Compra_Id = '{$solicitud_compra_id}', MetodoPago_Id = '{$metodopago_id}' 
                    WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/gestioncompra/index.php?resultado=2');
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
            <a href="/admin/gestioncompra/index.php" class="boton boton-verde">Volver</a>

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

                        <label for="MontoFinal">Monto</label>
                        <input name="MontoFinal" type="text" id="MontoFinal" placeholder="Monto Final" value="<?php echo $monto_final; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->

                <fieldset>
                    <legend>Solicitud Compra ID</legend>
                        <select name="SolicitudId" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $solicitud = mysqli_fetch_assoc($resultado_solicitud_compra) ) : ?>
                                <option  <?php echo $solicitud_compra_id === $solicitud['id'] ? 'selected' : ''; ?>  value="<?php echo $solicitud['id']; ?>" > <?php echo $solicitud['id']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end Fieldset  ---------->

                <fieldset>
                    <legend>Metodo Pago</legend>
                        <select name="MetodoId" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $metodo = mysqli_fetch_assoc($resultado_metodo_pago) ) : ?>
                                <option  <?php echo $metodopago_id === $metodo['id'] ? 'selected' : ''; ?>  value="<?php echo $metodo['id']; ?>" > <?php echo $metodo['Condicion']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Compra</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    mysqli_close($database);
    incluirTemplate('footer');

?>
