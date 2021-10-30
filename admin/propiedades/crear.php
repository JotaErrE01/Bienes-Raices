<?php
    require '../../includes/funciones.php';

    // Redireccionar a la página de inicio si no está logueado
    if(!isAuthenticated()){
        header('Location: /');
    }

    //Incluir la conexión a la base de datos
    require '../../includes/config/database.php';
    $db = conectarDb();

    // consultar para obtener los vendedores
    $query = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($db, $query);

    //arreglo con mensajes de errores
    $errores = array();

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';

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

        if(!$imagen['name']){
            $errores[] = 'La imagen es obligatoria';
        }

        // Validar el tamaño de la imagen
        if($imagen['size'] > 2000000){
            $errores[] = 'La imagen debe pesar menos de 2MB';
        }

        //obtener extension de la imagen para validarla
        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        if( $ext !== 'jpg' &&  $ext !== 'png' ){
            $errores[] = 'La imagen debe ser formato jpg o png';
        }

        if( empty($errores) ){

            /* Subida de archivos */
            //crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Generar nombre unico para imagenes
            $nombreImagen = md5(uniqid( rand(), true )) . ".{$ext}";

            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);         

            // insertar en la base de datos
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId) VALUES ('${titulo}', ${precio}, '${nombreImagen}', '${descripcion}', ${habitaciones}, ${wc}, ${estacionamiento}, '${creado}', '${vendedorId}');";
    
            $resultado = mysqli_query($db, $query);
            
            if($resultado){
                header('Location: /admin/index.php?resultado=1');
            }
        }
    }

    // Incluir plantilla del header
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input name="titulo" autocomplete="off" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input name="precio" autocomplete="off" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">

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

                <input type="submit" value="Crear Propiedad" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>