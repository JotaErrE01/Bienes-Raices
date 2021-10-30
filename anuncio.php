<?php
    //sanitizar el id del get
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /');
    }

    //importar conexion 
    require 'includes/config/database.php';
    $db = conectarDb();

    $query = "SELECT * FROM propiedades WHERE id = $id";
    $result = $db->query($query);
    
    if( $result->num_rows === 0 ){
        header('Location: /');
    }
    
    $propiedad = $result->fetch_assoc();
    
    require 'includes/funciones.php';
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo'] ?></h1>

        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen'] ?>" alt="Imagen Destacada">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio'] ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono-anuncio" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                    <p><?php echo $propiedad['wc'] ?></p>
                </li>

                <li>
                    <img class="icono-anuncio" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                    <p><?php echo $propiedad['estacionamiento'] ?></p>
                </li>

                <li>
                    <img class="icono-anuncio" src="build/img/icono_dormitorio.svg" alt="icono habitaciones" loading="lazy">
                    <p><?php echo $propiedad['habitaciones'] ?></p>
                </li>
            </ul>

            <p><?php echo $propiedad['descripcion'] ?></p>
        </div>
    </main>
<?php
    incluirTemplate( 'footer' );
    mysqli_close($db);
?>