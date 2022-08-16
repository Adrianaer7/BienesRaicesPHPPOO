<?php 
    require "../../includes/funciones.php";
    incluirTemplate("header", $pagina = "Admin - Crear");
    $auth = estadoAutenticado();
    if(!$auth) {
        header("Location: /");
    }
    //Base de datos
    require "../../includes/config/database.php";
    $db = conectarDB();

    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensaje de error
    $errores = [];

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedores_id = "";

    //Ejecutar el codigo despues que el usuario envia el codigo
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $titulo = mysqli_escape_string($db, $_POST["titulo"]);  //mysqli_escape_string sanitiza el campo, en caso que injecten una sentencia de sql o scripting, guarda eso como string y no como ejecutable en la bd 
        $precio = mysqli_escape_string($db, $_POST["precio"]);
        $descripcion = mysqli_escape_string($db, $_POST["descripcion"]);
        $habitaciones = mysqli_escape_string($db, $_POST["habitaciones"]);
        $wc = mysqli_escape_string($db, $_POST["wc"]);
        $estacionamiento = mysqli_escape_string($db, $_POST["estacionamiento"]);
        $vendedores_id = mysqli_escape_string($db, $_POST["vendedor"]);
        $creado = date("Y/m/d");
        
        //Asignar files hacia una variable. Los archivos no se leen por $_POST, sino por $_FILES
        $imagen = $_FILES["imagen"];    //accedo al name del input

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
        if(!$imagen["name"]) {
            $errores[] = "La imagen es obligatoria";
        }

        //Validar imagen por tamaño
        $medida = 1000 * 1000;   //bytes a kb (1Mb maximo)
        if($imagen["size"] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
            //Crear carpeta para subir archivo
            $carpetaImagenes = "../../imagenes/";   //guardo la ubicacion donde quiero que se cree la carpeta
            if(!is_dir($carpetaImagenes)) { //verifica si esa carpeta ya está creada
                mkdir($carpetaImagenes);    //crea la carpeta
            }
            //Generar un nombre unico para cada archivo
            $extension = pathinfo($imagen["name"], PATHINFO_EXTENSION); //La función pathinfo recibe en primer lugar una cadena, la cual representa al nombre del archivo. Y como segundo argumento una constante indicando qué información queremos extraer.
            $nombreImagen = md5(uniqid(rand(), true)).".$extension";  //mk5 devuelve un hash estatico. iniqid genera aleatorios
            //Guardar archivo en carpeta
            move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen);


            //Insertar en la bd
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) 
                      VALUES ('$titulo', $precio, '$nombreImagen', '$descripcion', $habitaciones, $wc, $estacionamiento, '$creado', $vendedores_id)";
    
            $resultado = mysqli_query($db, $query);

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
            <fieldset>
                <legend>Informacion general</legend>

                <label for="titulo">Titulo:</label>
                <input 
                    type="text" 
                    name="titulo" 
                    id="titulo" 
                    placeholder="Titulo Propiedad" 
                    value="<?php echo $titulo ?>"
                >

                <label for="precio">Precio:</label>
                <input 
                    type="number" 
                    name="precio" 
                    id="precio" 
                    placeholder="Precio Propiedad" 
                    value="<?php echo $precio ?>"
                >

                <label for="imagen">Imagen:</label>
                <input 
                    type="file" 
                    name="imagen" 
                    id="imagen"
                    accept="image/jpeg, image/png" 
                >

                <label for="descripcion">Descripcion:</label>
                <textarea 
                    name="descripcion" 
                    id="descripcion"
                ><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input 
                    type="number" 
                    name="habitaciones" 
                    id="habitaciones" 
                    placeholder="Ej. 3" 
                    min="1" 
                    max="9" 
                    value="<?php echo $habitaciones ?>"
                >

                <label for="wc">Baños:</label>
                <input 
                    type="number" 
                    name="wc" 
                    id="wc" 
                    placeholder="Ej. 1" 
                    min="1"
                    max="9" 
                    value="<?php echo $wc ?>"
                >

                <label for="estacionamiento">Estacionamiento:</label>
                <input 
                    type="number" 
                    name="estacionamiento" 
                    id="estacionamiento" 
                    placeholder="Ej. 2" 
                    min="1" 
                    max="9" 
                    value="<?php echo $estacionamiento ?>"
                >
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="">--Seleccione--</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)) { ?>    <!--el assoc convierte la tabla obtenida en un array asociativo-->
                        <!--al option le agrego la clase selected si ya envie el formulario y el id que envié es igual al que se encontró en la consulta a la bd-->
                        <option 
                            value="<?php echo $vendedor["id"];?>"
                            <?php echo $vendedores_id === $vendedor["id"] ? "selected" : ""; ?> 
                        >
                            <?php echo $vendedor["nombre"]." ".$vendedor["apellido"]; ?>
                        </option>
                    <?php }; ?>
                </select>
            </fieldset>

            <input 
                type="submit" 
                class="boton boton-verde"
                value="Crear propiedad" 
            >
        </form>
       
    </main>

<?php incluirTemplate("footer");?>