<fieldset>
    <legend>Informacion General</legend>

    <label for="titulo">Titulo:</label>
    <input name="titulo" autocomplete="off" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo escapar( $propiedad->titulo ); ?>">

    <label for="precio">Precio:</label>
    <input name="precio" autocomplete="off" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo escapar( $propiedad->precio ); ?>">

    <label for="imagen">Imagen:</label>
    <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">
    <?php if ( isset( $propiedadId ) ): ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="Imagen Propiedad" class="imagen-small">
    <?php endif ?>

    <label for="descripcion">Descripcion</label>
    <textarea name="descripcion" id="descripcion" cols="30" rows="10"><?php echo escapar( $propiedad->descripcion ); ?></textarea>

    <fieldset>
        <legend>Informacion Propiedad</legend>

        <label for="habitaciones">Habitaciones:</label>
        <input name="habitaciones" type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo escapar( $propiedad->habitaciones ); ?>">

        <label for="wc">Baños:</label>
        <input name="wc" type="number" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo escapar( $propiedad->wc ); ?>">

        <label for="estacionamiento">Estacionamiento:</label>
        <input name="estacionamiento" type="number" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo escapar( $propiedad->estacionamiento ); ?>">
    </fieldset>

    <fieldset>
        <legend>Vendedor</legend>

        <select name="vendedorId" id="">
            <option value="" disabled selected>-- Seleccione --</option>
            <?php foreach ($vendedores as $vendedor) : ?>
                <option <?php echo escapar($propiedad->vendedorId) === escapar($vendedor->id) ? 'selected' : ''; ?> value="<?php echo escapar($vendedor->id); ?>">
                    <?php echo escapar($vendedor->nombre) . ' ' . escapar($vendedor->apellido); ?></option>
            <?php endforeach ?>
        </select>
    </fieldset>