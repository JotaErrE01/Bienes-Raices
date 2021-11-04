<?php
    require '../../includes/app.php';

    use App\Vendedor;

    // Redireccionar a la página de inicio si no está logueado
    isAuthenticated();

    $vendedorId = filter_var( $_GET['id'], FILTER_VALIDATE_INT );

   //validar si existe un id
    if(!$vendedorId){
        header('Location: /admin');
    }

    $vendedor = Vendedor::find($_GET['id']);

    //validar si existe el vendedor
    if(!$vendedor){
        header('Location: /admin');
    }

    //Arreglo con los mensajes de errores
    $errores = Vendedor::getErrores();

    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

        //sincronizamos los datos del formulario con el objeto
        $vendedor->sincronizar( $_POST );

        $errores = $vendedor->validar();

        if( empty($errores) ){

            $resultado = $vendedor->actualizar();

            //redireccionar a la página de inicio admin
            if($resultado){
                header('Location: /admin?resultado=2');
            }

        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST">
                <?php 
                    include '../../includes/templates/formulario_vendedores.php';
                ?>
                <input type="submit" value="Actualizar Vendedor(a)" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>