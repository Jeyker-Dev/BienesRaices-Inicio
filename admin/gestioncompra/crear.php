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

    // Query to See data from Solicitud Compra
    $consulta_solicitud_compra  = "SELECT * FROM solicitud_compra";
    $resultado_solicitud_compra = mysqli_query($database, $consulta_solicitud_compra);

    // Query to See data from Metodo Pago
    $consulta_metodo_pago  = "SELECT * FROM metodo_pago";
    $resultado_metodo_pago = mysqli_query($database, $consulta_metodo_pago);

    // Array Errors
    $errores = [];

    $monto_final = '';
    $solicitud_compra_id = '';
    $metodopago_id = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $monto_final = mysqli_real_escape_string( $database, $_POST['MontoFinal'] );
        $solicitud_compra_id = mysqli_real_escape_string( $database, $_POST['SolicitudId'] );
        $metodopago_id = mysqli_real_escape_string( $database, $_POST['MetodoId'] );

        if(!$monto_final)
        {
            $errores[] = 'Debe Ingresar Un Monto';
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
            // Insert Into Database
            $query = "INSERT INTO gestioncompra (Monto_Final, Solicitud_Compra_Id, MetodoPago_Id) 
            VALUES ('{$monto_final}', '{$solicitud_compra_id}', '{$metodopago_id}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/gestioncompra/index.php?resultado=1");
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

            <form class="formulario" method="POST" action="/admin/gestioncompra/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="MontoFinal">Monto</label>
                        <input name="MontoFinal" type="number" id="MontoFinal" placeholder="Monto Final" value="<?php echo $monto_final; ?>" />

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

                <input type="submit" value="Crear Compra" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>