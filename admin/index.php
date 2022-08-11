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
    $resultadoConsulta = mysqli_query($db, $query);

    $resultado = $_GET["resultado"] ?? null;    //busca el resultado(variable que le paso al crear una nueva propiedad) en la URL y si no existe le asigno null
    
?>



    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <?php if(intval($resultado) === 1) { ?> <!--intval convierte el valor a numero-->
            <p class="alerta exito">Propiedad cargada correctamente</p>
        <?php } elseif(intval($resultado == 2)) { ?>
            <p class="alerta exito">Propiedad actualizada correctamente</p>
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
                <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)) { ?>
                <tr>
                    <td><?php echo $propiedad["id"]; ?></td>
                    <td><?php echo $propiedad["titulo"]; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad["imagen"]?>" class="imagen-tabla"></td>
                    <td>$<?php echo $propiedad["precio"]; ?></td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad["id"] ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

<?php 
    //Cerrar la conexion
    mysqli_close($db);
    incluirTemplate("footer");
?>