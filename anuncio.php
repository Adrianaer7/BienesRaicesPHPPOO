<?php 
    require "includes/funciones.php";
    incluirTemplate("header", $pagina = "Anuncio");

    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT );
    if(!$id) {
        header("Location:/admin");
    }
    //Conectar a la DB
    require "includes/config/database.php";
    $db = conectarDB();

    //Consulta
    $query = "SELECT * FROM PROPIEDADES WHERE id = $id";
    $resultado = mysqli_query($db, $query);
    $propiedad = mysqli_fetch_assoc($resultado);
    if($propiedad["id"] != $id) {
        header("Location: /admin");
    }
?>


    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad["titulo"]; ?></h1>
        <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpeg" type="image/jpeg">
            <img src="/imagenes/<?php echo $propiedad["imagen"]; ?>" alt="imagen de la propiedad" loading="lazy">
        </picture>
        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad["precio"]; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" src="build/img/icono_wc.svg" alt="icono wc" loading="lazy">
                    <p><?php echo $propiedad["wc"]; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento" loading="lazy">
                    <p><?php echo $propiedad["estacionamiento"]; ?></p>
                </li>
                <li>
                    <img class="icono" src="build/img/icono_dormitorio.svg" alt="icono dormitorio" loading="lazy">
                    <p><?php echo $propiedad["habitaciones"]; ?></p>
                </li>
            </ul>
            <p><?php echo $propiedad["descripcion"]; ?></p>        
        </div>
    </main>

<?php 
    mysqli_close();
    incluirTemplate("footer");
?>