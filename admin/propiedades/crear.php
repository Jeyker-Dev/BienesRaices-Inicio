<?php

    // Database
    require '../../includes/config/database.php';
    $database = conectarDB();

    // Include Functions And Header
    require '../../includes/app.php';
    require '../../includes/funciones.php';
    incluirTemplate('header');

    // Start Session
    $auth = estaAutenticado();

    // Query to See data from Sellers
    $consulta  = "SELECT * FROM vendedores";
    $resultado = mysqli_query($database, $consulta);
    
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

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorID = '';
    $tipopropiedad_id = '';
    $status_id = '';
    $representante_id = '';
    $categoria_id = '';

    // Run Code After Admin Send Form and Save In Database
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        /*
        $_POST // To See Information When Data is Send
            var_dump($_POST);

        $_FILES // To See Information of Archives, for example an Image
            var_dump($$_FILES);
        */

        $titulo = mysqli_real_escape_string( $database, $_POST['Titulo'] );
        $precio = mysqli_real_escape_string( $database, $_POST['Precio'] );
        $descripcion = mysqli_real_escape_string( $database, $_POST['Descripcion'] );
        $habitaciones = mysqli_real_escape_string( $database, $_POST['Habitaciones'] );
        $wc = mysqli_real_escape_string( $database, $_POST['Wc'] );
        $estacionamiento = mysqli_real_escape_string( $database, $_POST['Estacionamiento'] );
        $vendedorID = mysqli_real_escape_string( $database, $_POST['Vendedor'] );
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

        if(!$vendedorID)
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

        if(!$imagen['name'])
        {
            $errores[] = 'La Imagen es Obligatoria';
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

         // Create Unique Name
        $nombreImagen = md5( uniqid( rand(), true ));

         // Upload Image
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . "/" . $nombreImagen . ".jpg");

        // Insert in Database
        $query = " INSERT INTO propiedades ( titulo, precio, imagen ,descripcion, habitaciones, wc, estacionamiento, creado, vendedorId, tipopropiedad_id, status_id, representante_id, categoria_id) 
        VALUES ( '$titulo', '$precio', '$nombreImagen' ,'$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorID', '$tipopropiedad_id', '$status_id', '$representante_id', '$categoria_id');";

        $resultado = mysqli_query($database, $query);

        // Send User to Another Page is Data is Insert Correctly in Database
            if($resultado)
            {
                header('Location: /admin/propiedades/?resultado=1');
            }   // Here End If
        }   // Here End If
    }   // Here End If

    // If Session ain't right go back to index
    if(!$auth)
    {
        header('Location: /');
    }   // Here End If

?>

<!-- Body   -->
    <main class="contenedor seccion">
        <h1>Crear Propiedad</h1>
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
            <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
                <fieldset>
                    <legend>Informacion General</legend>

                        <label for="Titulo">Nombre de la propiedad</label>
                        <input name="Titulo" type="text" id="Titulo" placeholder="Nombre de la Propiedad" value="<?php echo $titulo; ?>" />

                        <label for="Precio">Precio ($)</label>
                        <input name="Precio" type="number" id="btnAll" placeholder="Precio de la Propiedad" value="<?php echo $precio; ?>" />

                        <label for="Imagen">Imagen</label>
                        <input name="Imagen" type="file" id="Imagen de la Propiedad" accept="image/jpeg, image/png" />

                        <label for="Descripcion">Descripcion</label>
                        <textarea name="Descripcion" id="Descripcion" cols="30" rows="10"> <?php echo $descripcion; ?></textarea>
                </fieldset>
<!----------  Here end Fieldset  ---------->
                <fieldset>
                            <legend>Informacion Propiedad</legend>

                            <label for="Habitaciones">Cantidad de Habitaciones</label>
                            <input name="Habitaciones" type="number" id="Cantidad de Habitaciones" placeholder="Habitaciones: (Ejemplo: 4)" min="1" max="15" value="<?php echo $habitaciones; ?>" />
        
                            <label for="Baños">Cantidad de Baños</label>
                            <input name="Wc" type="number" id="Baños" placeholder="Baños: (Ejemplo: 2)" min="1" max="10" value="<?php echo $wc; ?>" />

                            <label for="Estacionamiento">Estacionamiento</label>
                            <input name="Estacionamiento" type="number" id="Estacionamiento" placeholder="Capacidad de Coches: (Ejemplo: 1)" min="1" max="50" value="<?php echo $estacionamiento; ?>" />

                </fieldset>
<!----------  Here end FieldSet  ---------->
                <fieldset>
                    <legend>Nombre del Vendedor</legend>
                        <a href="/admin/vendedores/crear.php" class="boton-agregar">Añadir</a>
                        <select name="Vendedor" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $vendedor = mysqli_fetch_assoc($resultado) ) : ?>
                                <option  <?php echo $vendedorID === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>" > <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->

                <fieldset>
                    <legend>Tipo de Propiedad</legend>
                        <a href="/admin/tipopropiedad/crear.php" class="boton-agregar">Añadir</a>
                        <select name="TipoPropiedad" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $tipopropiedad = mysqli_fetch_assoc($resultadoTipopropiedad) ) : ?>
                                <option  <?php echo $tipopropiedad_id === $tipopropiedad['id'] ? 'selected' : ''; ?>  value="<?php echo $tipopropiedad['id']; ?>" > <?php echo $tipopropiedad['TipoPropiedad']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->

                <fieldset>
                    <legend>Status de la Propiedad</legend>
                        <a href="/admin/status/crear.php" class="boton-agregar">Añadir</a>
                        <select name="Status" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $status = mysqli_fetch_assoc($resultadoStatus) ) : ?>
                                <option  <?php echo $status_id === $status['id'] ? 'selected' : ''; ?>  value="<?php echo $status['id']; ?>" > <?php echo $status['Tipo_Estado']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->


                <fieldset>
                    <legend>Representante de la Propiedad</legend>
                        <a href="/admin/representante/crear.php" class="boton-agregar">Añadir</a>
                        <select name="Representante" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $representante = mysqli_fetch_assoc($resultadoRepresentantes) ) : ?>
                                <option  <?php echo $representante_id === $representante['id'] ? 'selected' : ''; ?>  value="<?php echo $representante['id']; ?>" > <?php echo $representante['Nombre_repr'] . " " . $representante['Apellido_repr']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->

                <fieldset>
                    <legend>Categoria de la Propiedad</legend>
                        <a href="/admin/categorias/crear.php" class="boton-agregar">Añadir</a>
                        <select name="Categoria" id="">
                        <option value="">-- Seleccione --</option>
                            <?php while( $categoria = mysqli_fetch_assoc($resultadoCategorias) ) : ?>
                                <option  <?php echo $categoria_id === $categoria['id'] ? 'selected' : ''; ?>  value="<?php echo $categoria['id']; ?>" > <?php echo $categoria['Categoria_Propiedad']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                </fieldset>
<!----------  Here end FieldSet  ---------->

                <input type="submit" value="Crear Propiedad" class="boton boton-verde" />

<!----------  Here end Submit  ---------->
            </form>
<!----------  Here end Form  ---------->
    </main>
<!----------  Here end Main  ---------->
<?php
    // Include Footer
    incluirTemplate('footer');

?>