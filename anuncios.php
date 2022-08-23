<?php 
    require "includes/app.php";

    incluirTemplate("header", $pagina = "Anuncios");
?>



    <main class="contenedor seccion">
        <h2>Casas y Departamentos en Venta</h2>
        <?php 
            $limite = 10;    //paso esta variable al include
            include "includes/templates/anuncios.php";
        ?>
    </main>

<?php incluirTemplate("footer");?>