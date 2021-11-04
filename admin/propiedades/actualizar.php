<?php

require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

    // Redireccionar a la página de inicio si no está logueado
    isAuthenticated();

    $propiedadId = filter_var( $_GET['id'], FILTER_VALIDATE_INT );

    //validar si existe un id
    if(!$propiedadId){
        header('Location: /admin');
    }
    
    // buscamos una propiedad por su id
    $propiedad = Propiedad::find($propiedadId);

    // Verificar si la propiedad existe
    if(!$propiedad){
        header('Location: /admin');
    }

    // consultar para obtener los vendedores
    $vendedores = Vendedor::all();

    //arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    // Ejecutar el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        $propiedad->sincronizar( $_POST );

        /* Subida de archivos */            
        if( $_FILES['imagen']['tmp_name'] ){
            //detectar extension de la imagen subida
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

            //Generar nombre unico para imagenes
            $nombreImagen = md5(uniqid( rand(), true )) . ".{$ext}";
            
            // Realiza un resize a la imagen con intervention image
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);

            //Guardar el nombre de la imagen en la instancia del objeto
            $propiedad->setImagen($nombreImagen);
        }

        // Validar los datos antes de guardarlos en la base de datos
        $errores = $propiedad->validar();

        if( empty($errores) ){
            if( $image ){
                // Guardar la imagen en la carpeta del servidor
                $image->save(CARPETA_IMAGENES . $propiedad->imagen);
            }

            $resultado = $propiedad->actualizar();
            
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
                <?php 
                    include '../../includes/templates/formulario_propiedades.php';
                ?>
                <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>