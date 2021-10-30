<?php

    // importar la base de datos
    require 'includes/config/database.php';
    $db = conectarDb();

    $errores = [];

    // Autenticar al usuario
    if( $_SERVER['REQUEST_METHOD'] === 'POST' ){

        // validar email y password
        $email = mysqli_real_escape_string( $db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) );
        $password = mysqli_real_escape_string( $db, $_POST['password'] );

        if( !$email ){
            $errores['email'] = 'El email no es valido';
        }

        if(!$password){
            $errores['password'] = 'El password no es valido';
        }

        if( empty($errores) ){
            // validar que el usuario exista
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query( $db, $query );

            if( $resultado->num_rows ){
                //Revisar si el password es correcto
                $usuario = $resultado->fetch_assoc();
                if( password_verify( $password, $usuario['password'] ) ){
                    // Iniciar sesion
                    session_start();
                    //llenar arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    header('Location: /admin');
                }else{
                    $errores['password'] = 'El password no es correcto';
                }
            }else{
                $error['incorrecto'] = 'El usuario no Existe';
            }
        }
    }

    //Incluye el header
    require 'includes/funciones.php';
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php 
            foreach( $errores as $error ):
        ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/login.php" >
            <fieldset>
                <legend>Email y Password</legend>
                <label for="email">E-mail</label>
                <input name="email" type="email" id="email" placeholder="Tu Email" require>

                <label for="password">Password</label>
                <input name="password" type="password" id="password" placeholder="Tu Password" require>
            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">
        </form>
    </main>
<?php
    incluirTemplate( 'footer' );
?>