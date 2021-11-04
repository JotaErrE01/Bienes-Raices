<?php
    require '../../includes/app.php';
    
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    $propiedad = new Propiedad(); //creamos el objeto vacio

    // Redireccionar a la página de inicio si no está logueado
    isAuthenticated();

    //Incluir la conexión a la base de datos
    $db = conectarDb();

    // consultar para obtener los vendedores
    $vendedores = Vendedor::all();

    //arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    // Ejecutar el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Instanciamos el objeto Propiedad.
        $propiedad = new Propiedad( $_POST );
        
        if( $_FILES['imagen']['tmp_name'] ){
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

            //Generar nombre unico para imagenes
            $nombreImagen = md5(uniqid( rand(), true )) . ".{$ext}";

            //Guardar el nombre de la imagen en la instancia del objeto
            $propiedad->setImagen($nombreImagen);
        }
        
        $errores = $propiedad->validar();
        
        if( empty($errores) ){
            /* SUBIDA DE ARCHIVOS */
            // crear la carpeta imagenes
            if(!CARPETA_IMAGENES){
                mkdir(CARPETA_IMAGENES);
            } 
            
            // Realiza un resize a la imagen con intervention image
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
            
            // Guardar la imagen en la carpeta del servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            // Guardar en la base de datos
            $resultado = $propiedad->guardar();

            if($resultado){
                header('Location: /admin/index.php?resultado=1');
            }
        }
    }

    // Incluir plantilla del header
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion">
        <h1>Crear Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
                <?php 
                    include '../../includes/templates/formulario_propiedades.php';
                ?>
                <input type="submit" value="Crear Propiedad" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>