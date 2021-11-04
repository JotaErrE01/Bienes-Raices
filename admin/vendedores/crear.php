<?php
    require '../../includes/app.php';

    use App\Vendedor;

    // Redireccionar a la página de inicio si no está logueado
    isAuthenticated();

    // creamos un objeto vacio de vendedor
    $vendedor = new Vendedor();
    
    //Arreglo con los mensajes de errores
    $errores = Vendedor::getErrores();
    
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){        
        // creamos la instancia del objeto vendedor
        $vendedor = new Vendedor($_POST);

        $errores = $vendedor->validar();

        if( empty($errores) ){

            $resultado = $vendedor->guardar();

            if( $resultado ){
                header('Location: /admin?resultado=1');
            }

        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
        <h1>Registrar Vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach ?>

        <form class="formulario" method="POST" action="/admin/vendedores/crear.php" >
                <?php 
                    include '../../includes/templates/formulario_vendedores.php';
                ?>
                <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
            </fieldset>
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>