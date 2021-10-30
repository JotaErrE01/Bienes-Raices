<?php
    require '../includes/funciones.php';

    // Redireccionar a la página de inicio si no está logueado
    if(!isAuthenticated()){
        header('Location: /');
    }

    // Importar la conecion a la base de datos
    require '../includes/config/database.php';
    $db = conectarDb();

    $query = "SELECT * FROM propiedades";

    // consultar la base de datos
    $resultado = mysqli_query($db, $query);

    //muestra mensaje condicional
    $mensaje = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        if($id){

            //Eliminar la imagen del servidor
            $query = "SELECT imagen FROM propiedades WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($resultado);
            $imagen = $row['imagen'];
            unlink('../imagenes/'. $imagen);
            

            //Eliminar propiedad de la base de datos
            $query = "DELETE FROM propiedades WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);
            if($resultado){
                header('Location: /admin/index.php?resultado=3');
            }
        }
    }

    //Incluye un template
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php if ( $mensaje == 1 ) : ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php elseif ( $mensaje == 2 ) : ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php elseif ( $mensaje == 3 ) : ?>
            <p class="alerta exito">Anuncio Eliminado Correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php while( $propiedad = mysqli_fetch_assoc($resultado) ): ?>
                    <tr>
                        <td><?php echo $propiedad['id']; ?></td>
                        <td><?php echo $propiedad['titulo']; ?></td>
                        <td><img class="imagen-tabla" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen-tabla"></td>
                        <td>$<?php echo $propiedad['precio']; ?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?php echo $propiedad['id'] ?>" class="hidden" >
                                <button type="submit" class="boton-rojo-block">Eliminar</button>
                            </form>
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id'] ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </main>
<?php
    //cerrar la conexion a la base de datos de mysqli 
    mysqli_close($db);

    incluirTemplate( 'footer' );
?>