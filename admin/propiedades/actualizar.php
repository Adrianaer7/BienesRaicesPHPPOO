<?php

    use App\Propiedad;

    require "../../includes/app.php";
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
    $errores = [];

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
        
        $propiedad->sincronizar($args); //modifico el objeto original por el objeto que está en memoria
        debugear($propiedad);
        //Asignar files hacia una variable. Los archivos no se leen por $_POST, sino por $_FILES
        $imagen = $_FILES["propiedad"]["imagen"];    //accedo al name del input
        

        if(!$titulo) {
            $errores[] = "El titulo es obligatorio";
        }
        if(!$precio) {
            $errores[] = "El precio es obligatorio";
        }
        if(strlen($descripcion) < 50) {
            $errores[] = "La descripcion es obligatoria y tiene que tener como minimo 50 caracteres";
        }
        if(!$habitaciones) {
            $errores[] = "El numero de habitaciones es obligatorio";
        }
        if(!$wc) {
            $errores[] = "El numero de baños es obligatorio";
        }
        if(!$estacionamiento) {
            $errores[] = "La capacidad del garage es obligatorio";
        }
        if(!$vendedores_id) {
            $errores[] = "El nombre del vendedor es obligatorio";
        }

        //Validar imagen por tamaño
        $medida = 1000 * 1000;   //bytes a kb (1Mb maximo)
        if($imagen["size"] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
            //Crear carpeta para subir imagen
            $carpetaImagenes = "../../imagenes/";   //guardo la ubicacion donde quiero que se cree la carpeta
            if(!is_dir($carpetaImagenes)) { //verifica si esa carpeta ya está creada
                mkdir($carpetaImagenes);    //crea la carpeta
            }

            $nombreImagen = "";

            //Si el _$FILES detecta que se subio una imagen, y previamente la propiedad ya tenia una guardada, la elimino
            if($imagen["name"]) {
                //Eliminar imagen previa
                unlink($carpetaImagenes . $propiedad["imagen"]);

                //Generar un nombre unico para cada imagen
                $extension = pathinfo($imagen["name"], PATHINFO_EXTENSION); //La función pathinfo recibe en primer lugar una cadena, la cual representa al nombre del archivo. Y como segundo argumento una constante indicando qué información queremos extraer.
                $nombreImagen = md5(uniqid(rand(), true)).".$extension";  //mk5 devuelve un hash estatico. iniqid genera aleatorios
                //Guardar imagen en carpeta
                move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen);
            } else {
                //si se actualiza la propiedad pero no se sube nueva imagen, sobreescribe en la bd lo que ya tenia
                $nombreImagen = $propiedad["imagen"];
            }



            //Insertar en la bd
            $query = "UPDATE propiedades 
                      SET titulo = '$titulo', precio = $precio, imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id = $vendedores_id
                      WHERE id = $id";
            $resultado = mysqli_query($db, $query);

            //Redireccionar
            if($resultado) {
                header("Location: /admin?resultado=2"); //no se puede usar en el html. Le paso el string resultado para que en el index se lo muestre
            }
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