<?php 
    //Importar template
    require "includes/funciones.php";
    incluirTemplate("header");

    //Importar BD
    require "includes/config/database.php";
    $db = conectarDB();

    //Autinticar el usuario
    $errores = [];

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = mysqli_real_escape_string($db, filter_var($_POST["email"], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST["password"]);

        if(!$email) {
            $errores[] = "El email es obligatorio o no válido";
        }
        if(!$password) {
            $errores[] = "La contraseña es obligatoria";
        }

        if(empty($errores)) {
            
        }
    }   
?>



    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>
        <?php foreach($errores as $error) {?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php } ?>
        <form method="POST" class="formulario" novalidate>  <!--novalidate es para que no me salgan las alertas de html por campo invalido-->
            <fieldset>
                <legend>Email y contraseña</legend>

                <label for="email">Email</label>
                <input 
                    type="email" 
                    placeholder="Tu email" 
                    id="email"
                    name="email"
                >

                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    placeholder="Tu contraseña" 
                    id="password"
                    name="password"
                >
            </fieldset>   
            <input 
                type="submit" 
                class="boton boton-verde"
                value="Iniciar Sesión"
            >
        </form>
    </main>

<?php incluirTemplate("footer");?>