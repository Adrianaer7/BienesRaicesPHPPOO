<?php 
    require "includes/funciones.php";

    incluirTemplate("header", $pagina = "Anuncio");
?>


    <main class="contenedor seccion contenido-centrado">
        <h1>Casa en venta frente al bosque</h1>
        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpeg" type="image/jpeg">
            <img src="build/img/destacada.jpg" alt="imagen de la propiedad" loading="lazy">
        </picture>
        <div class="resumen-propiedad">
            <p class="precio">$3.000.000</p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                    <p>3</p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio" loading="lazy">
                    <p>4</p>
                </li>
            </ul>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
            </p>        
        </div>
    </main>

<?php incluirTemplate("footer");?>