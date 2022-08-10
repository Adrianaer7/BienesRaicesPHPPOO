<?php 
    //Importar template
    require "../includes/funciones.php";
    incluirTemplate("header", $pagina = "Admin - Inicio");

    //Importar la conexion
    require "../includes/config/database.php";
    $db = conectarDB();
    //Escribir el Query
    $query = "SELECT * FROM propiedades";
    //Consultar a la BD
    $resultado = mysqli_query($db, $query);

    exit;
    $resultado = $_GET["resultado"] ?? null;    //busca el resultado en la URL y si no existe le asigno null
    
?>



    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <?php if(intval($resultado) === 1) { ?> <!--intval convierte el valor a numero-->
            <p class="alerta exito">Propiedad cargada correctamente</p>
        <?php } ?>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>     
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Casa en la playa</td>
                    <td><img src="/imagenes/archivo.jpg" class="imagen-tabla"></td>
                    <td>$120000</td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="#" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

<?php 
    //Cerrar la conexion

    incluirTemplate("footer");
?>