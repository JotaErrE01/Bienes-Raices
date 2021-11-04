<?php
    use App\Propiedad;

    if( $_SERVER['REQUEST_URI'] === '/anuncios.php' ){
        //Consulta para obtener todas las propiedades
        $propiedades = Propiedad::all();
    }else{
        //Consulta para obtener un limite de propiedades
        $propiedades = Propiedad::get(3);
    }
?>


<div class="contenedor-anuncios">

    <?php 
        //Recorrer las propiedades
        foreach($propiedades as $propiedad):
    ?>
        <div class="anuncio">
            <img loading="lazy" src="<?php echo 'imagenes/' . $propiedad->imagen ?>" alt="anuncio">
            

            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo; ?></h3>
                <p><?php echo $propiedad->descripcion; ?></p>
                <p class="precio">$<?php echo $propiedad->precio; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>

                    <li>
                        <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                    </li>

                    <li>
                        <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono habitaciones" loading="lazy">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $propiedad->id; ?>" class="boton boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div>
        </div>
    <?php endforeach;?>
</div>


<?php 
    //cerrar la conexion
    mysqli_close($db);
?>