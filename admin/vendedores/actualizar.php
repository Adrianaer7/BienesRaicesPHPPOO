<?php
    require "../../includes/app.php";
    use App\Vendedor;

    incluirTemplate("header", $pagina = "Admin - Actualizar");
    estadoAutenticado();
    
    //Validar que el id por URL que recibo sea numero entero
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header("Location:/admin");
    }


    //Consultar para obtener los datos de la vendedor
    $vendedor = Vendedor::find($id);
    //Validar que la id que pongo en la url sea existente en la BD
    if($vendedor->id != $id) {
        header("Location: /admin");
    }


    //Arreglo con mensaje de error
    $errores = Vendedor::getErrores();


    //Ejecutar el codigo despues que el usuario envia el form
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Asignar los atributos
        $args = $_POST["vendedor"];  //en el name de cada input, le agrego vendedor["name"] para que el $_POST cree un array con todos los datos. De esta manera le paso solo ese array a los args

        //Actualizar los atributos en memoria
        $vendedor->sincronizar($args); //modifico el objeto original por el objeto que está en memoria

        //Validar los atributos
        $errores = $vendedor->validar();

        
        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
            //Guardar en la BD
            $vendedor->guardar();
        }
    }
?>

    <main class="contenedor seccion">
        <h1>Actualizar vendedor</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error) { ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <!--El enctype del form permite que se suban archivos mediante el $_FILE-->
        <form 
            method="POST" 
            class="formulario" 
        >
            <?php include "../../includes/templates/formulario_vendedores.php"; ?>

            <input 
                type="submit" 
                class="boton boton-verde"
                value="Guardar cambios" 
            >
        </form>
       
    </main>

<?php incluirTemplate("footer");?>