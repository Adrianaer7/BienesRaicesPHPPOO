<?php
    require "../../includes/app.php";
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    incluirTemplate("header", $pagina = "Admin - Actualizar");
    estadoAutenticado();
    
    //Validar que el id por URL que recibo sea numero entero
    $id = $_GET["id"];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header("Location:/admin");
    }
    //Base de datos
    $db = conectarDB();

    //Consultar para obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    //Validar que la id que pongo en la url sea existente en la BD
    if($propiedad->id != $id) {
        header("Location: /admin");
    }
    //Consultar los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de error
    $errores = Propiedad::getErrores();

    $titulo = $propiedad->titulo;
    $precio = $propiedad->precio;
    $imagenPropiedad= $propiedad->imagen;
    $descripcion = $propiedad->descripcion;
    $habitaciones = $propiedad->habitaciones;
    $wc = $propiedad->wc;
    $estacionamiento = $propiedad->estacionamiento;
    $vendedores_id = $propiedad->vendedores_id;

    //Ejecutar el codigo despues que el usuario envia el codigo
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        //Asignar los atributos
        $args = $_POST["propiedad"];  //en el name de cada input, le agrego propiedad["name"] para que el $_POST cree un array con todos los datos. De esta manera le paso solo ese array a los args

        //Actualizar los atributos en memoria
        $propiedad->sincronizar($args); //modifico el objeto original por el objeto que está en memoria

        //Subida de archivos
        //Generar un nombre unico para cada archivo
        $extension = pathinfo($_FILES["propiedad"]["name"]["imagen"], PATHINFO_EXTENSION); //La función pathinfo recibe en primer lugar una cadena, la cual representa al nombre del archivo. Y como segundo argumento una constante indicando qué información queremos extraer.
        $nombreImagen = md5(uniqid(rand(), true)).".$extension";  //mk5 devuelve un hash estatico. iniqid genera aleatorios
        

        //Validar los atributos
        $errores = $propiedad->validar();

        
        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
            //Realizar resize a la imagen con Intervention
            if($_FILES["propiedad"]["tmp_name"]["imagen"]) {  //si existe una imagen
                $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);  //hago un recorte de resolucion de la imagen
                $propiedad->setImagen($nombreImagen);   //envio el nombre de la imagen a la propiedad de la clase
                
                //Almacenar la imagen
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
         
            
            //Guardar en la BD
            $propiedad->guardar();
        }
    }

?>


    <main class="contenedor seccion">
        <h1>Actualizar propiedad</h1>
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
            enctype="multipart/form-data"
        >
            <?php include "../../includes/templates/formulario_propiedades.php"; ?>

            <input 
                type="submit" 
                class="boton boton-verde"
                value="Guardar cambios" 
            >
        </form>
       
    </main>

<?php incluirTemplate("footer");?>