<?php 
    //Importar template
    require "../includes/app.php";
    use App\Propiedad;
    use App\Vendedor;

    incluirTemplate("header", $pagina = "Admin - Inicio");
    estadoAutenticado();

    //Obtener las propiedades
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    $resultado = $_GET["resultado"] ?? null;    //busca el resultado(variable que le paso al crear una nueva propiedad) en la URL y si no existe le asigno null

    //Cuando presione en eliminar
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST["id"]; //id es el name del input
        $id = filter_var($id, FILTER_VALIDATE_INT); //valida que sea un numero

        if($id) {
            $tipo = $_POST["tipo"];
            if(validarTipoContenido($_POST["tipo"])) {
                if($tipo == "vendedor") {
                    //Consultar para obtener los datos del vendedor
                    $vendedor = Vendedor::find($id);
                    //Elimino el vendedor
                    $vendedor->eliminar();
                } else if($tipo == "propiedad") {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }

        }
    }
?>

    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <?php 
            $mensaje = mostrarNotificacion(intval($resultado));
            if($mensaje) { ?>
                <p class="alerta exito"><?php echo s($mensaje); ?></p>
            <?php } ?>
        
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>     
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo vendedor</a>     

        <h2>Propiedades</h2>
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
                            <input type="hidden" name="tipo" value="propiedad">
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

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vendedores as  $vendedor) { ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre; ?></td>
                    <td><?php echo $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a 
                            href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id ?>" 
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
    incluirTemplate("footer");
?>