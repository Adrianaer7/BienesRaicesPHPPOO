<?php 
    require "../../includes/app.php";
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    incluirTemplate("header", $pagina = "Admin - Crear");
    estadoAutenticado();

    //Base de datos
    $db = conectarDB();

    //Instancia vacia
    $propiedad = new Propiedad;

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de error
    $errores = Propiedad::getErrores(); //la primera vez va a estar vacio. Esto es para que no marque unedefined

    //Ejecutar el codigo despues que el usuario envia el codigo
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Instancio la clase
        $propiedad = new Propiedad($_POST);

        //Generar un nombre unico para cada archivo
        $extension = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION); //La función pathinfo recibe en primer lugar una cadena, la cual representa al nombre del archivo. Y como segundo argumento una constante indicando qué información queremos extraer.
        $nombreImagen = md5(uniqid(rand(), true)).".$extension";  //mk5 devuelve un hash estatico. iniqid genera aleatorios

        //Realizar resize a la imagen con Intervention
        if($_FILES["imagen"]["tmp_name"]) {  //si existe una imagen
            $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,600);  //hago un recorte de resolucion de la imagen
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
            $resultado = $propiedad->guardar();

            //Redireccionar
            if($resultado) {
                header("Location: /admin?resultado=1"); //no se puede usar en el html. Le paso el string resultado para que en el index se lo muestre
            }
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