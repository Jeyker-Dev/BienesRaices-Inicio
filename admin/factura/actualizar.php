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

        // Query to See data from Cliente
        $consulta_clientes  = "SELECT * FROM cliente";
        $resultado_clientes = mysqli_query($database, $consulta_clientes);

        // Query to See data from Estado Compra
        $consulta_gestioncompra  = "SELECT * FROM gestioncompra";
        $resultado_gestioncompra = mysqli_query($database, $consulta_gestioncompra);

// Array Errors
    $errores = [];

    // Get Id From Url
    $id = $_GET['id'];

    // Validate Id From Url
    $id = filter_var( $id, FILTER_VALIDATE_INT );

       // Get Data From Factura
        $consultaFactura = "SELECT * FROM categoria WHERE id = {$id}";
        $resultadoConsultaFactura = mysqli_query($database, $consultaFactura);
        $factura = mysqli_fetch_assoc($resultadoConsultaFactura);

        $fecha_factura = $factura['Fecha_Factura'];
        $gestioncompra_id = $factura['GestionCompra_Id'];
        $cliente_ci = $factura['Client_CI'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/factura/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $fecha_factura = mysqli_real_escape_string( $database, $_POST['FechaFactura'] );
                $gestioncompra_id = mysqli_real_escape_string( $database, $_POST['GestionCompraId'] );
                $cliente_ci = mysqli_real_escape_string( $database, $_POST['ClienteCi'] );

                if(!$fecha_factura)
                {
                    $errores[] = 'Se Debe Agregar Una Fecha';
                }   // Here End If

                if(!$gestioncompra_id)
                {
                    $errores[] = 'Debe Seleccionar Un Id de Gestion';
                }   // Here End If
        
                if(!$cliente_ci)
                {
                    $errores[] = 'Debe Sellecionar Una Cedula de Cliente';
                }   // Here End If

                if( empty( $errores ) )
                {
                    // Update in Database
                    $query = "UPDATE factura SET Fecha_Factura = '{$fecha_factura}', GestionCompra_Id = '{$gestioncompra_id}', Client_CI = '{$cliente_ci}'
                    WHERE id = {$id};";
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/factura/index.php?resultado=2');
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
            <a href="/admin/factura/index.php" class="boton boton-verde">Volver</a>

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

            <form  id="confirmForm" class="formulario" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="FechaFactura">Fecha de la Factura</label>
                        <input name="FechaFactura" type="date" id="FechaFactura" placeholder="Fecha de la Factura" value="<?php echo $fecha_factura; ?>" />

                </fieldset>
<!----------  Here end Fieldset  ---------->


                <fieldset>
                    <legend>Cedula Cliente</legend>
                    <select name="ClienteCi" id="">
                    <option value="">-- Seleccione --</option>
                    <?php while ($cliente = mysqli_fetch_assoc($resultado_clientes)) : ?>
                    <option <?php echo $cliente_ci === $cliente['CI_client'] ? 'selected' : ''; ?> value="<?php echo $cliente['CI_client']; ?>"> <?php echo $cliente['CI_client']; ?> </option>
                    <?php endwhile; ?>
                    </select>
                </fieldset>
<!----------  Here end Fieldset  ---------->

                <fieldset>
                    <legend>ID de Gestion de la Compra</legend>
                        <select name="GestionCompraId" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $gestioncompra = mysqli_fetch_assoc($resultado_gestioncompra) ) : ?>
                                <option  <?php echo $gestioncompra_id === $gestioncompra['id'] ? 'selected' : ''; ?>  value="<?php echo $gestioncompra['id']; ?>" > <?php echo $gestioncompra['id']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end Fieldset  ---------->

               <label for="btn-confirm" class="boton boton-verde">Actualizar Factura</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
