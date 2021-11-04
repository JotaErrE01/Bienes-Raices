<fieldset>
    <legend>Informacion General</legend>

    <label for="nombre">Nombre:</label>
    <input name="nombre" autocomplete="off" type="text" id="nombre" placeholder="Nombre del Vendedor(a)" value="<?php echo escapar( $vendedor->nombre ); ?>">

    <label for="apellido">Apellido:</label>
    <input name="apellido" autocomplete="off" type="text" id="apellido" placeholder="Apellido del Vendedor(a)" value="<?php echo escapar( $vendedor->apellido ); ?>">
</fieldset>

<fieldset>
    <legend>Informacion Extra</legend>
    
    <label for="telefono">Telefono</label>
    <input name="telefono" autocomplete="off" type="tel" id="telefono" placeholder="Telefono del Vendedor(a)" value="<?php echo escapar( $vendedor->telefono ); ?>">
</fieldset>