<?php 
    //Importar template
    require "../includes/app.php";
    use App\Propiedad;

    incluirTemplate("header", $pagina = "Admin - Inicio");
    estadoAutenticado();

    //Obtener las propiedades
    $propiedades = Propiedad::all();

    $resultado = $_GET["resultado"] ?? null;    //busca el resultado(variable que le paso al crear una nueva propiedad) en la URL y si no existe le asigno null

    //Cuando presione en eliminar
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST["id"]; //id es el name del input
        $id = filter_var($id, FILTER_VALIDATE_INT); //valida que sea un numero

        if($id) {
            //Elimino la imagen
            $query = "SELECT imagen FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            unlink("../imagenes/" . $propiedad["imagen"]);
            
            //Elimino la propiedad
            $query = "DELETE FROM propiedades WHERE id = $id";
            $resultado = mysqli_query($db, $query);
            //Redirecciono
            if($resultado) {
                header("Location: /admin?resultado=3");
            }
        }
    }
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <?php if(intval($resultado) === 1) { ?> <!--intval convierte el valor a numero-->
            <p class="alerta exito">Propiedad cargada correctamente</p>
        <?php } elseif(intval($resultado == 2)) { ?>
            <p class="alerta exito">Propiedad actualizada correctamente</p>
        <?php } elseif(intval($resultado == 3)) { ?>
            <p class="alerta exito">Propiedad eliminada correctamente</p>
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
                <?php foreach($propiedades as  $propiedad) { ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen?>" class="imagen-tabla" alt="imagen propiedad"></td>
                    <td>$<?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a 
                            href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" 
                            class="boton-amarillo-block"
                        >
                            Actualizar
                        </a>
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