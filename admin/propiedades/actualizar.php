<?php

    // Database
    require '../../includes/config/database.php';
    $database = conectarDB();

    // Include Functions And Header
    require '../../includes/app.php';
    require '../../includes/funciones.php';
    incluirTemplate('header');
    
    // Dialogo
    require '../../includes/template/dialogos.php';

    // Start Session
    $auth = estaAutenticado();

    // Get Id from Url
    $id = $_GET['id'];

    // Validate URL
    $id = filter_var($id, FILTER_VALIDATE_INT);

    // Get Data From Propiedad
    $consultaPropiedades = "SELECT * FROM propiedades WHERE id = {$id}";
    $resultadoConsultaPropiedades = mysqli_query($database, $consultaPropiedades);
    $propiedad = mysqli_fetch_assoc($resultadoConsultaPropiedades);

    // Query to See data from Sellers
    $consultaVendedores  = "SELECT * FROM vendedores";
    $resultadoConsultaVendedores = mysqli_query($database, $consultaVendedores);

        // Query to See data from Properties Type
        $consultaTipopropiedad = "SELECT * FROM tipopropiedad";
        $resultadoTipopropiedad = mysqli_query($database, $consultaTipopropiedad);
    
        // Query to See data from Status
        $consultaStatus = "SELECT * FROM status";
        $resultadoStatus = mysqli_query($database, $consultaStatus);
    
        // Query to See data from Representantes
        $consultaRepresentantes = "SELECT * FROM representante";
        $resultadoRepresentantes = mysqli_query($database, $consultaRepresentantes);
    
        // Query to See data from Properties Type
        $consultaCategorias = "SELECT * FROM categoria";
        $resultadoCategorias = mysqli_query($database, $consultaCategorias);

        // Array Errors
        $errores = [];

        $titulo = $propiedad["titulo"];
        $precio = $propiedad["precio"];
        $descripcion = $propiedad["descripcion"];
        $habitaciones = $propiedad["habitaciones"];
        $wc = $propiedad["wc"];
        $estacionamiento = $propiedad["estacionamiento"];
        $vendedorID = $propiedad["vendedorId"];
        $tipopropiedad_id = $propiedad['tipopropiedad_id'];
        $status_id = $propiedad['status_id'];
        $representante_id = $propiedad['representante_id'];
        $categoria_id = $propiedad['categoria_id'];
        $imagenPropiedad = $propiedad['imagen'];

    // If ain't Id send it to Admin
    if(!$id)
    {
        header('Location:/admin/propiedades/');
    }   // Here End If

    // Run Code After Admin Send Form and Save In Database
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {

        /*
        $_POST // To See Information When Data is Send
            var_dump($_POST);

        $_FILES // To See Information of Archives, for example an Image
            var_dump($_FILES);
        */

        $titulo = mysqli_real_escape_string( $database, $_POST['Titulo'] );
        $precio = mysqli_real_escape_string( $database, $_POST['Precio'] );
        $descripcion = mysqli_real_escape_string( $database, $_POST['Descripcion'] );
        $habitaciones = mysqli_real_escape_string( $database, $_POST['Habitaciones'] );
        $wc = mysqli_real_escape_string( $database, $_POST['Wc'] );
        $estacionamiento = mysqli_real_escape_string( $database, $_POST['Estacionamiento'] );
        $vendedorId = mysqli_real_escape_string( $database, $_POST['Vendedor'] );
        $tipopropiedad_id = mysqli_real_escape_string( $database, $_POST['TipoPropiedad'] );
        $status_id = mysqli_real_escape_string( $database, $_POST['Status'] );
        $representante_id = mysqli_real_escape_string( $database, $_POST['Representante'] );
        $categoria_id = mysqli_real_escape_string( $database, $_POST['Categoria'] );
        $creado = date('y/m/d');

        // Add Archives toward a variable
        $imagen = $_FILES['Imagen'];

        // Validate Size
        $medida = 1000 * 1000;

        if($imagen['size'] > $medida)
        {
            $errores[] = 'La Imagen es muy pesada por favor selecciona otra con menos de 1MB';
        }   // Here End If

        if($titulo === '')
        {
            $errores[] = 'Debes Agregar un Titulo';
        }   // Here End IF

        if(!$precio)
        {
            $errores[] = 'El Precio es Obligatorio';
        }   // Here End IF

        if(!$descripcion)
        {
            $errores[] = 'La Descripcion No Puede Estar Vacio y Debe Tener al Menos 50 Caracteres';
        }   // Here End IF

        if(!$habitaciones)
        {
            $errores[] = 'Debe Haber un Numero de Habitaciones';
        }   // Here End IF

        if(!$wc)
        {
            $errores[] = 'Debe Haber un Numero de Baños';
        }   // Here End IF

        if(!$estacionamiento)
        {
            $errores[] = 'Debe Haber un Numero de Estacionamiento';
        }   // Here End IF

        if(!$vendedorId)
        {
            $errores[] = 'Debe Seleccionar un Vendedor';
        }   // Here End IF

        if(!$tipopropiedad_id)
        {
            $errores[] = 'Debe Seleccionar un Tipo de la Propiedad';
        }   // Here End IF

        if(!$status_id)
        {
            $errores[] = 'Debe Seleccionar un Status';
        }   // Here End IF

        if(!$representante_id)
        {
            $errores[] = 'Debe Seleccionar un Representante';
        }   // Here End IF

        if(!$categoria_id)
        {
            $errores[] = 'Debe Seleccionar una Categoria';
        }   // Here End IF

        // Look if Array Errors is Empty and Then Run Code
        if(empty( $errores ))
        {

        // Create Folder
        $carpetaImagenes = '../../imagenes';

        // Look if Folder ain't created and Then Created The Folder
        if(!is_dir($carpetaImagenes))
        {
            mkdir($carpetaImagenes);
        }   // Here End If

        $nombreImagen = '';

        if($imagen['name'])
        {
            // Delete Preview Image
            unlink($carpetaImagenes . $propiedad['imagen']);

        // Create Unique Name
        $nombreImagen = md5( uniqid( rand(), true ) );

        // Upload Image
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . "/" . $nombreImagen . ".jpg");
        }   // Here end If
        else
        {
            $nombreImagen = $propiedad['imagen'];
        }   // Here End Else

        // Update in Database
        $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}',descripcion = '{$descripcion}', 
        habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedorId = {$vendedorId},
        tipopropiedad_id = '{$tipopropiedad_id}', status_id = '{$status_id}', representante_id = '{$representante_id}', categoria_id = '{$categoria_id}' WHERE id = {$id};";
        $resultado = mysqli_query($database, $query);

        // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/propiedades/?resultado=2');
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
            <a href="/admin/propiedades/" class="boton boton-verde">Volver</a>

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

                        <label for="Titulo">Nombre de la propiedad</label>
                        <input name="Titulo" type="text" id="Titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>" />

                        <label for="Precio">Precio ($)</label>
                        <input name="Precio" type="number" id="Precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>" />

                        <label for="Imagen">Imagen</label>
                        <input name="Imagen" type="file" id="Imagen" accept="image/jpeg, image/png" />

                        <img class="imagen-small" src="/imagenes/<?php echo $propiedad['imagen']; ?>.jpg" alt="Imagen Casa">

                        <label for="Descripcion">Descripcion</label>
                        <textarea name="Descripcion" id="Descripcion" cols="30" rows="10"> <?php echo $descripcion; ?></textarea>
                </fieldset>
<!----------  Here end Fieldset  ---------->
                <fieldset>
                            <legend>Informacion Propiedad</legend>

                            <label for="Habitaciones">Habitaciones</label>
                            <input name="Habitaciones" type="number" id="Habitaciones" placeholder="Habitaciones: (Ejemplo: 4)" min="1" max="15" value="<?php echo $habitaciones; ?>" />
                            <a href="/admin/propiedades/" class="boton">Volver</a>

                            <label for="Baños">Baños</label>
                            <input name="Wc" type="number" id="Baños" placeholder="Baños: (Ejemplo: 2)" min="1" max="10" value="<?php echo $wc; ?>" />

                            <label for="Estacionamiento">Estacionamiento</label>
                            <input name="Estacionamiento" type="number" id="Estacionamiento" placeholder="Estacionamiento: (Ejemplo: 1)" min="1" max="50" value="<?php echo $estacionamiento; ?>" />
                </fieldset>
<!----------  Here end FieldSet  ---------->
                <fieldset>
                    <legend>Nombre del Vendedor</legend>
                        <select name="Vendedor" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $vendedor = mysqli_fetch_assoc($resultadoConsultaVendedores) ) : ?>
                                <option  <?php echo $vendedorID === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>" > <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?> </option>
                                <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->
                <fieldset>
                    <legend>Tipo de Propiedad</legend>
                        <select name="TipoPropiedad" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $tipopropiedad = mysqli_fetch_assoc($resultadoTipopropiedad) ) : ?>
                                <option  <?php echo $tipopropiedad_id === $tipopropiedad['id'] ? 'selected' : ''; ?>  value="<?php echo $tipopropiedad['id']; ?>" > <?php echo $tipopropiedad['TipoPropiedad']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->

                <fieldset>
                    <legend>Status Propiedad</legend>
                        <select name="Status" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $status = mysqli_fetch_assoc($resultadoStatus) ) : ?>
                                <option  <?php echo $status_id === $status['id'] ? 'selected' : ''; ?>  value="<?php echo $status['id']; ?>" > <?php echo $status['Tipo_Estado']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->


                <fieldset>
                    <legend>Representante Propiedad</legend>
                        <select name="Representante" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $representante = mysqli_fetch_assoc($resultadoRepresentantes) ) : ?>
                                <option  <?php echo $representante_id === $representante['id'] ? 'selected' : ''; ?>  value="<?php echo $representante['id']; ?>" > <?php echo $representante['Nombre_repr'] . " " . $representante['Apellido_repr']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->

                <fieldset>
                    <legend>Categoria Propiedad</legend>
                        <select name="Categoria" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $categoria = mysqli_fetch_assoc($resultadoCategorias) ) : ?>
                                <option  <?php echo $categoria_id === $categoria['id'] ? 'selected' : ''; ?>  value="<?php echo $categoria['id']; ?>" > <?php echo $categoria['Categoria_Propiedad']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->


<label for="btn-confirm" class="boton boton-verde">Actualizar Propiedad</label>
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