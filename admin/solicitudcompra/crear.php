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

     // Query to See data from Propiedades
    $consulta_propiedades  = "SELECT * FROM propiedades";
    $resultado_propiedades = mysqli_query($database, $consulta_propiedades);

       // Query to See data from Cliente
    $consulta_clientes  = "SELECT * FROM cliente";
    $resultado_cliente = mysqli_query($database, $consulta_clientes);

       // Query to See data from Estado Compra
    $consulta_estado_compra  = "SELECT * FROM estado_compra";
    $resultado_estado_compra = mysqli_query($database, $consulta_estado_compra);

// Array Errors
    $errores = [];

    $fecha = '';
    $propiedades_id = '';
    $client_ci = '';
    $estado_id = '';

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $fecha = mysqli_real_escape_string( $database, $_POST['Fecha'] );
        $propiedades_id = mysqli_real_escape_string( $database, $_POST['PropiedadId'] );
        $client_ci = mysqli_real_escape_string( $database, $_POST['ClienteCi'] );
        $estado_id = mysqli_real_escape_string( $database, $_POST['EstadoId'] );

        if(!$fecha)
        {
            $errores[] = 'Debe Ingresar Una Fecha';
        }   // Here End If

        if(!$propiedades_id)
        {
            $errores[] = 'Debe Sellcionar Una Propiedad';
        }   // Here End If

        if(!$client_ci)
        {
            $errores[] = 'Debe Sellcionar Un Cliente';
        }   // Here End If

        if(!$estado_id)
        {
            $errores[] = 'Debe Sellcionar Un Estado Compra';
        }   // Here End If

        if( empty( $errores ) )
        {
            // Insert Into Database
            $query = "INSERT INTO solicitud_compra (Fecha, Client_CI, Propiedades_Id, Estado_Id) 
            VALUES ('{$fecha}', '{$client_ci}', '{$propiedades_id}', '{$estado_id}')";

            $resultado = mysqli_query( $database, $query );

            if($resultado)
            {
                header("Location: /admin/solicitudcompra/index.php?resultado=1");
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

            <form class="formulario" method="POST" action="/admin/solicitudcompra/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Fecha">Fecha Solicitud</label>
                        <input name="Fecha" type="date" id="Fecha" placeholder="Fecha" value="<?php echo $fecha; ?>" />

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
                <input type="submit" value="Crear Solicitud" class="boton boton-verde" />
<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->

<?php
    // Include Footer
    incluirTemplate('footer');

?>