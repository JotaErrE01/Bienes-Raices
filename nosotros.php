<?php
    require 'includes/app.php';
    incluirTemplate( 'header' );
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <img loading="lazy" src="build/img/nosotros.jpg" alt="Sobre Nosotros">
                </picture>
            </div>

            <div class="texto-nosotros">
                <blockquote>
                    25 años de experiencia
                </blockquote>

                <p>Consequat aute sint eiusmod irure irure esse do dolor nulla deserunt. Ut dolor labore proident do esse ea deserunt exercitation anim voluptate consectetur exercitation. Adipisicing eu occaecat dolor qui reprehenderit laborum consectetur aliquip cupidatat. Reprehenderit eu deserunt adipisicing fugiat anim ea consequat minim nisi ad anim incididunt incididunt adipisicing. Dolore anim cillum aliquip mollit reprehenderit commodo elit. Labore ex labore eu ipsum consectetur est quis enim minim dolor laboris reprehenderit sit culpa.</p>
                <p>Aute ea commodo enim cupidatat ullamco proident excepteur. Exercitation dolor pariatur magna Lorem duis do velit officia sit laboris excepteur est. Sit duis adipisicing id pariatur.
                Commodo voluptate adipisicing veniam ea eiusmod enim ea. Aliquip eu consequat sunt aute Lorem commodo reprehenderit. In ex ex et irure fugiat mollit duis pariatur cillum. Incididunt eiusmod tempor exercitation ea. Eu occaecat mollit velit esse nulla culpa voluptate sit dolore voluptate.</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy" >
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, facilis? Et quos natus doloribus, veritatis, libero eos rerum aliquam laborum rem, dolores praesentium aspernatur magni. Eveniet veritatis ratione alias facilis?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy" >
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, facilis? Et quos natus doloribus, veritatis, libero eos rerum aliquam laborum rem, dolores praesentium aspernatur magni. Eveniet veritatis ratione alias facilis?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy" >
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, facilis? Et quos natus doloribus, veritatis, libero eos rerum aliquam laborum rem, dolores praesentium aspernatur magni. Eveniet veritatis ratione alias facilis?</p>
            </div>
        </div>
    </section>
<?php
    incluirTemplate( 'footer' );
?>