<?php 
    require "../includes/funciones.php";

    incluirTemplate("header", $pagina = "Admin - Inicio");
?>



    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>     
    </main>

<?php incluirTemplate("footer");?>