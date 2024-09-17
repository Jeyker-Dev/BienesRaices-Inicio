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

    
     // Query to See data from Propiedades
    $consulta_propiedades  = "SELECT * FROM propiedades";
    $resultado_propiedades = mysqli_query($database, $consulta_propiedades);

        // Query to See data from Sellers
    $consulta_clientes  = "SELECT * FROM cliente";
    $resultado_cliente = mysqli_query($database, $consulta_clientes);

        // Query to See data from Sellers
    $consulta_estado_compra  = "SELECT * FROM estado_compra";
    $resultado_estado_compra = mysqli_query($database, $consulta_estado_compra);

 // Array Errors
    $errores = [];

    $fecha = '';
    $propiedades_id = '';
    $client_ci = '';
    $estado_id = '';

    // Get Id From Url
    $id = $_GET['id'];

    // Validate Id From Url
    $id = filter_var( $id, FILTER_VALIDATE_INT );

       // Get Data From Solicitud Compra
        $consultaSolicitudCompra = "SELECT * FROM solicitud_compra WHERE id = {$id}";
        $resultadoConsultaSolicitudCompra = mysqli_query($database, $consultaSolicitudCompra);
        $solicitud_compra = mysqli_fetch_assoc($resultadoConsultaSolicitudCompra);

        $fecha = $solicitud_compra['Fecha'];
        $propiedades_id = $solicitud_compra['Propiedades_Id'];
        $cliente_ci = $solicitud_compra['Client_CI'];
        $estado_id = $solicitud_compra['Estado_Id'];

            // If ain't Id send it to Admin
            if(!$id)
            {
                header('Location:/admin/solicitudcompra/');
            }   // Here End If

            if($_SERVER["REQUEST_METHOD"] === "POST")
            {
                $fecha = mysqli_real_escape_string( $database, $_POST['Fecha'] );
                $propiedades_id = mysqli_real_escape_string( $database, $_POST['PropiedadId'] );
                $cliente_ci = mysqli_real_escape_string( $database, $_POST['ClienteCi'] );
                $estado_id = mysqli_real_escape_string( $database, $_POST['EstadoId'] );

                if(!$fecha)
                {
                    $errores[] = 'Se Debe Agregar Una Fecha';
                }   // Here End If

                if(!$propiedades_id)
                {
                    $errores[] = 'Debe Seleccionar Una Propiedad';
                }   // Here End If
        
                if(!$cliente_ci)
                {
                    $errores[] = 'Debe Seleccionar Un Cliente';
                }   // Here End If
        
                if(!$estado_id)
                {
                    $errores[] = 'Debe Seleccionar Un Estado Compra';
                }   // Here End If
                if( empty( $errores ) )
                {

                    // Update in Database
                    $query = "UPDATE solicitud_compra SET Fecha = '{$fecha}', Client_CI = '{$cliente_ci}', Propiedades_Id = '{$propiedades_id}', Estado_Id = '{$estado_id}'
                    WHERE id = {$id};";
                    
                    $resultado = mysqli_query($database, $query);

             // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/solicitudcompra/index.php?resultado=2');
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
            <a href="/admin/solicitudcompra/index.php" class="boton boton-verde">Volver</a>

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

                        <label for="Fecha">Fecha Solicitud</label>
                        <input name="Fecha" type="text" id="Fecha" placeholder="Fecha" value="<?php echo $fecha; ?>" />

                    </fieldset>
<!----------  Here end Fieldset  ---------->

<fieldset>
                    <legend>Cedula Cliente</legend>
                    <select name="ClienteCi" id="">
                    <option value="">-- Seleccione --</option>
                    <?php while ($cliente = mysqli_fetch_assoc($resultado_cliente)) : ?>
                    <option <?php echo $cliente_ci === $cliente['CI_client'] ? 'selected' : ''; ?> value="<?php echo $cliente['CI_client']; ?>"> <?php echo $cliente['CI_client']; ?> </option>
                    <?php endwhile; ?>
</select>
                </fieldset>
<!----------  Here end Fieldset  ---------->

                <fieldset>
                    <legend>Nombre de la Propiedad</legend>
                        <select name="PropiedadId" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $propiedades = mysqli_fetch_assoc($resultado_propiedades) ) : ?>
                                <option  <?php echo $propiedades_id === $propiedades['id'] ? 'selected' : ''; ?>  value="<?php echo $propiedades['id']; ?>" > <?php echo $propiedades['titulo']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end Fieldset  ---------->


                <fieldset>
                    <legend>Estado de la Compra</legend>
                        <select name="EstadoId" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $estado_compra = mysqli_fetch_assoc($resultado_estado_compra) ) : ?>
                                <option  <?php echo $estado_id === $estado_compra['id'] ? 'selected' : ''; ?>  value="<?php echo $estado_compra['id']; ?>" > <?php echo $estado_compra['Tipo_Estado']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end Fieldset  ---------->
               <label for="btn-confirm" class="boton boton-verde">Actualizar Solicitud</label>
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>
