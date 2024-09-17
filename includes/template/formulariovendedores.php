<fieldset>
<legend>Informacion General</legend>

<label for="Nombre">Nombre</label>
<input name="nombre" type="text" id="Nombre" placeholder="Nombre Vendedor" value="<?php echo escaparHTML($vendedores->nombre); ?>" />

<label for="Apellido">Apellido</label>
<input name="apellido" type="text" id="Apellido" placeholder="Apellido Vendedor" value="<?php echo escaparHTML($vendedores->apellido); ?>" />

<label for="Telefono">Telefono</label>
<input name="telefono" type="number" id="Telefono" placeholder="Telefono Vendedor" value="<?php echo escaparHTML($vendedores->telefono); ?>" />

</fieldset>