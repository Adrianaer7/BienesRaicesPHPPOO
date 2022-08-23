<?php 
    require "includes/app.php";

    incluirTemplate("header", $pagina = "Nosotros");
?>


    <section class="contenedor seccion">
        <h1>Conoce sobre nosotros</h1>
        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpeg" type="image/jpeg">
                    <img src="build/img/nosotros.jpg" alt="sobre nosotros" loading="lazy">
                </picture>
            </div>
            <div class="texto-nosotros">
                <blockquote>25 años de experiencia</blockquote>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
                </p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur assumenda ex eius impedit minus debitis ipsa consequuntur exercitationem doloribus pariatur officiis ab, at beatae maxime labore laboriosam et molestiae quae.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                </p>
            </div>
        </div>
        
    </section>

    <main class="contenedor seccion">
        <h1>Más sobre nosotros</h1>
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem, voluptatibus magnam! Tempora deleniti maxime ea laudantium? Facere laudantium itaque recusandae dolor, expedita accusantium eligendi ipsam iure nemo, delectus modi tenetur?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
                <h3>El mejor precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem, voluptatibus magnam! Tempora deleniti maxime ea laudantium? Facere laudantium itaque recusandae dolor, expedita accusantium eligendi ipsam iure nemo, delectus modi tenetur?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono tiempo" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatem, voluptatibus magnam! Tempora deleniti maxime ea laudantium? Facere laudantium itaque recusandae dolor, expedita accusantium eligendi ipsam iure nemo, delectus modi tenetur?</p>
            </div>
        </div>
    </main>
    
<?php incluirTemplate("footer");?>