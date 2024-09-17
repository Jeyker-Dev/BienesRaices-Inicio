<fieldset>
<legend>Informacion General</legend>

<label for="Titulo">Titulo</label>
<input name="titulo" type="text" id="Titulo" placeholder="Titulo Propiedad" value="<?php echo escaparHTML($propiedad->titulo); ?>" />

<label for="Precio">Precio</label>
<input name="precio" type="number" id="Precio" placeholder="Precio Propiedad" value="<?php echo escaparHTML($propiedad->precio); ?>" />

<label for="Imagen">Imagen</label>
<input name="imagen" type="file" id="Imagen" accept="image/jpeg, image/png" />

<?php
    if($propiedad->imagen):
?>
    <img src="../../includes/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Casa" class="imagen-small">
<?php
    endif;
?>

<label for="Descripcion">Descripcion</label>
<textarea name="descripcion" id="Descripcion" cols="30" rows="10"> <?php echo escaparHTML( $propiedad->descripcion); ?> </textarea>
</fieldset>
<!----------  Here end Fieldset  ---------->
<fieldset>
    <legend>Informacion Propiedad</legend>

    <label for="Habitaciones">Habitaciones</label>
    <input name="habitaciones" type="number" id="Habitaciones" placeholder="Habitaciones: Ejemplo: 4" min="1" max="15" value="<?php echo escaparHTML($propiedad->habitaciones); ?>" />

    <label for="Baños">Baños</label>
    <input name="wc" type="number" id="Baños" placeholder="Baños: Ejemplo: 4" min="1" max="10" value="<?php echo escaparHTML($propiedad->wc); ?>" />

    <label for="Estacionamiento">Estacionamiento</label>
    <input name="estacionamiento" type="number" id="Estacionamiento" placeholder="Estacionamiento: Ejemplo: 4" min="1" max="50" value="<?php echo escaparHTML($propiedad->estacionamiento); ?>" />
</fieldset>
<!----------  Here end FieldSet  ---------->
    <fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="vendedorId" id="vendedor">
    <?php foreach($vendedores as $vendedor): ?>
        <option selected value="">-- Seleccione --</option>
        <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?>
        value="<?php echo escaparHTML( $vendedor->id); ?>"> <?php echo escaparHTML($vendedor->nombre) . " " . escaparHTML($vendedor->apellido); ?> </option>
    <?php endforeach;?>
    </select>
    </fieldset>
<!----------  Here end FieldSet  ---------->