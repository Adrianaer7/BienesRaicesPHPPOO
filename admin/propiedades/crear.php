<?php 
    require "../../includes/app.php";
    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    incluirTemplate("header", $pagina = "Admin - Crear");
    estadoAutenticado();


    //Instancia vacia
    $propiedad = new Propiedad;
    $vendedores = Vendedor::all();

    //Arreglo con mensaje de error
    $errores = Propiedad::getErrores(); //la primera vez va a estar vacio. Esto es para que no marque unedefined

    //Ejecutar el codigo despues que el usuario envia el codigo
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Instancio la clase
        $propiedad = new Propiedad($_POST["propiedad"]);    //en el name de cada input, le agrego propiedad["name"] para que el $_POST cree un array con todos los datos.

        //Generar un nombre unico para cada archivo
        $extension = pathinfo($_FILES["propiedad"]["name"]["imagen"], PATHINFO_EXTENSION); //La función pathinfo recibe en primer lugar una cadena, la cual representa al nombre del archivo. Y como segundo argumento una constante indicando qué información queremos extraer.
        $nombreImagen = md5(uniqid(rand(), true)).".$extension";  //mk5 devuelve un hash estatico. iniqid genera aleatorios

        //Realizar resize a la imagen con Intervention
        if($_FILES["propiedad"]["tmp_name"]["imagen"]) {  //si existe una imagen
            $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);  //hago un recorte de resolucion de la imagen
            $propiedad->setImagen($nombreImagen);   //envio el nombre de la imagen a la propiedad de la clase
        }

        //Valido los datos
        $errores = $propiedad->validar();
        
        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
            //Crear carpeta para las imagenes si no existe
            if(!is_dir(CARPETA_IMAGENES)) { //carpeta_imagenes viene de funciones.php
                mkdir(CARPETA_IMAGENES);
            }

            //Guarda la imagen en la carpeta
            $image->save(CARPETA_IMAGENES . $nombreImagen);
             
            //Guardo en la BD
            $propiedad->guardar();
        }
    }

?>


    <main class="contenedor seccion">
        <h1>Crear propiedad</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error) { ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <!--El enctype del form permite que se suban archivos mediante el $_FILE-->
        <form 
            method="POST" 
            action="/admin/propiedades/crear.php"
            class="formulario" 
            enctype="multipart/form-data"
        >
            <?php include "../../includes/templates/formulario_propiedades.php"; ?>

            <input 
                type="submit" 
                class="boton boton-verde"
                value="Crear propiedad" 
            >
        </form>
       
    </main>

<?php incluirTemplate("footer");?>