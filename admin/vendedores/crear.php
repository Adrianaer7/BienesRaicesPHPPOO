<?php 
    require "../../includes/app.php";
    use App\Vendedor;

    incluirTemplate("header", $pagina = "Admin - Crear");
    estadoAutenticado();

    //Instancia vacia
    $vendedor = new Vendedor;

    //Arreglo con mensaje de error
    $errores = Vendedor::getErrores(); //la primera vez va a estar vacio. Esto es para que no marque unedefined

    //Ejecutar el codigo despues que el usuario envia el codigo
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Instancio la clase
        $vendedor = new Vendedor($_POST["vendedor"]);    //en el name de cada input, le agrego vendedor["name"] para que el $_POST cree un array con todos los datos.


        //Valido los datos
        $errores = $vendedor->validar();

        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
          
            //Guardo en la BD
            $vendedor->guardar();
        }
    }

?>


    <main class="contenedor seccion">
        <h1>Crear vendedor</h1>
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
            action="/admin/vendedores/crear.php"
        >
            <?php include "../../includes/templates/formulario_vendedores.php"; ?>

            <input 
                type="submit" 
                class="boton boton-verde"
                value="Crear vendedor" 
            >
        </form>
       
    </main>

<?php incluirTemplate("footer");?>