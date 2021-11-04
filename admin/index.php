<?php
    require '../includes/app.php';

    //Importar las clases
    use App\Propiedad;
    use App\Vendedor;

    // Redireccionar a la página de inicio si no está logueado
    isAuthenticated();

    // Implementar un metodo para obtener todas las propiedades
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        if($id){
            if(validarTipoContenido($_POST['tipo'])){
                if( $_POST['tipo'] === 'vendedor' ){
                    $vendedor = Vendedor::find($id);
                    $vendedor->delete();
                }else{
                    $propiedad = Propiedad::find($id);
                    $propiedad->delete();
                }
            }
        }
    }

    //Incluye un template
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>

        <?php 
            $mensaje = mostrarNotificacion( intval( $resultado ) );
            if( $mensaje ): ?>
            <p class="alerta exito"><?php echo escapar( $mensaje ) ?></p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo(a) Vendedor</a>

        <h2>Propiedades</h2>
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
                <?php foreach( $propiedades as $propiedad ): ?>
                    <tr>
                        <td><?php echo $propiedad->id; ?></td>
                        <td><?php echo $propiedad->titulo; ?></td>
                        <td><img class="imagen-tabla" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen-tabla"></td>
                        <td>$<?php echo $propiedad->precio; ?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?php echo $propiedad->id ?>" class="hidden" >
                                <input type="hidden" name="tipo" value="propiedad" class="hidden" >
                                <button type="submit" class="boton-rojo-block">Eliminar</button>
                            </form>
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach( $vendedores as $vendedor ): ?>
                    <tr>
                        <td><?php echo $vendedor->id; ?></td>
                        <td><?php echo $vendedor->nombre; ?></td>
                        <td><?php echo $vendedor->telefono; ?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>" class="hidden" >
                                <input type="hidden" name="tipo" value="vendedor" class="hidden" >
                                <button type="submit" class="boton-rojo-block">Eliminar</button>
                            </form>
                            <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
<?php
    //cerrar la conexion a la base de datos de mysqli 
    mysqli_close($db);

    incluirTemplate( 'footer' );
?>