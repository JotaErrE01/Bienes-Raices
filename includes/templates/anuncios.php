<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    //Importar la base de datos
    require __DIR__ . '/../config/database.php';
    $db = conectarDb();

    //Consulta para obtener las propiedades
    $sql = "SELECT * FROM propiedades LIMIT ${limit}";
    $propiedades = mysqli_query($db, $sql);
?>


<div class="contenedor-anuncios">

    <?php 
        //Recorrer las propiedades
        while($propiedad = mysqli_fetch_assoc($propiedades)):
    ?>
        <div class="anuncio">
            <img loading="lazy" src="<?php echo 'imagenes/' . $propiedad['imagen'] ?>" alt="anuncio">
            

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio">$<?php echo $propiedad['precio']; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                        <p><?php echo $propiedad['wc']; ?></p>
                    </li>

                    <li>
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                        <p><?php echo $propiedad['estacionamiento']; ?></p>
                    </li>

                    <li>
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones" loading="lazy">
                        <p><?php echo $propiedad['habitaciones']; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="boton boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div>
        </div>
    <?php endwhile;?>
</div>


<?php 
    //cerrar la conexion
    mysqli_close($db);
?>