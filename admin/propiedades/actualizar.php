<?php
    require '../../includes/funciones.php';

    // Redireccionar a la página de inicio si no está logueado
    if(!isAuthenticated()){
        header('Location: /');
    }

    $propiedadId = filter_var( $_GET['id'], FILTER_VALIDATE_INT );

    //validar si existe un id
    if(!$propiedadId){
        header('Location: /admin');
    }

    //Incluir la conexión a la base de datos
    require '../../includes/config/database.php';
    $db = conectarDb();

    //Consultar la base de datos para obtener los datos de la propiedad
    $query = "SELECT * FROM propiedades WHERE id = {$propiedadId}";
    $propiedad = mysqli_fetch_assoc( $db->query($query) );

    // Verificar si la propiedad existe
    if(!$propiedad){
        header('Location: /admin');
    }

    // consultar para obtener los vendedores
    $query = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($db, $query);

    //arreglo con mensajes de errores
    $errores = array();

    $titulo = $propiedad['titulo'];
    $descripcion = $propiedad['descripcion'];
    $precio = $propiedad['precio'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedorId'];
    $propiedadImagen = $propiedad['imagen'];

    // Ejecutar el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
        $precio = mysqli_real_escape_string($db, $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
        $wc = mysqli_real_escape_string($db, $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
        $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
        $creado = date('Y-m-d');

        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];

        // Validar los datos antes de guardarlos en la base de datos
        if(!$titulo){
            $errores[] = 'El titulo es obligatorio';
        }

        if(!$precio){
            $errores[] = 'El precio es obligatorio';
        }

        if(strlen($descripcion) < 50){
            $errores[] = 'La descripcion es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$habitaciones){
            $errores[] = 'El numero de habitaciones es obligatorio';
        }

        if(!$wc){
            $errores[] = 'El numero de baños es obligatorio';
        }

        if(!$estacionamiento){
            $errores[] = 'El numero de estacionamientos es obligatorio';
        }

        if(!$vendedorId){
            $errores[] = 'Seleccione un Vendedor';
        }

        // Validar el tamaño de la imagen
        if($imagen['size'] > 2000000){
            $errores[] = 'La imagen debe pesar menos de 2MB';
        }

        //obtener extension de la imagen para validarla
        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        if( $ext !== 'jpg' &&  $ext !== 'png' && $ext !== '' ){
            $errores[] = 'La imagen debe ser formato jpg o png';
        }

        if( empty($errores) ){

            /* Subida de archivos */
            //crear carpeta
            $carpetaImagenes = '../../imagenes/';
            $nombreImagen = '';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            // verificar que el archivo exista y evitar que se elimine la anterior imagen
            if($ext !== '' && file_exists($carpetaImagenes . $propiedadImagen)){
                //Eliminar imagen previa
                unlink($carpetaImagenes . $propiedadImagen);

                //Generar nombre unico para imagen subida
                $nombreImagen = md5(uniqid( rand(), true )) . ".{$ext}";

                // Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); 
            }else{
                $nombreImagen = $propiedadImagen;
            }

            // actualizar en la base de datos
            $query = "UPDATE propiedades SET titulo = '{$titulo}', precio = {$precio}, descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedorId = {$vendedorId}, imagen = '{$nombreImagen}', creado = '{$creado}' WHERE id = {$propiedadId}";
    
            $resultado = mysqli_query($db, $query);
            
            if($resultado){
                header('Location: /admin/index.php?resultado=2');
            }
        }
    }

    // incluir template del header
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input name="titulo" autocomplete="off" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input name="precio" autocomplete="off" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">
                <img src="/imagenes/<?php echo $propiedadImagen ?>" alt="Imagen Propiedad" class="imagen-small">

                <label for="descripcion">Descripcion</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="10"><?php echo $descripcion; ?></textarea>

                <fieldset>
                    <legend>Informacion Propiedad</legend>

                    <label for="habitaciones">Habitaciones:</label>
                    <input name="habitaciones" type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                    <label for="wc">Baños:</label>
                    <input name="wc" type="number" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                    <label for="estacionamiento">Estacionamiento:</label>
                    <input name="estacionamiento" type="number" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
                </fieldset>

                <fieldset>
                    <legend>Vendedor</legend>

                    <select name="vendedor" id="">
                        <option value="" disabled selected>-- Seleccione --</option>
                        <?php  while( $vendedor = mysqli_fetch_assoc( $vendedores ) ): ?>
                            <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>">
                            <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?></option>
                        <?php endwhile ?>
                    </select>
                </fieldset>

                <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>