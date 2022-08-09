<?php 
    //Base de datos
    require "../../includes/config/database.php";
    $db = conectarDB();

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
        

        $titulo = $_POST["titulo"];
        $precio = $_POST["precio"];
        $descripcion = $_POST["descripcion"];
        $habitaciones = $_POST["habitaciones"];
        $wc = $_POST["wc"];
        $estacionamiento = $_POST["estacionamiento"];
        $vendedores_id = $_POST["vendedor"];

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

        //Revisar que el array de errores esté vacio
        if(empty($errores)) {
            //Insertar en la bd
            $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id) 
                      VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedores_id')";
    
            $resultado = mysqli_query($db, $query);   
            if($resultado) {
                echo "Insertado correctamente";
            }
        }


    }

    require "../../includes/funciones.php";
    incluirTemplate("header", $pagina = "Admin - Crear");
?>


    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error) { ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form 
            method="POST" 
            action="/admin/propiedades/crear.php"
            class="formulario" 
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
                >
                    <?php echo $descripcion ?>
                </textarea>
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
                    <option value="1">Adrian</option>
                    <option value="2">Eduardo</option>

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