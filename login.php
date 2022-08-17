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
        
        //Revisar errores del usuario
        if(!$email) {
            $errores[] = "El email es obligatorio o no válido";
        }
        if(!$password) {
            $errores[] = "La contraseña es obligatoria";
        }

        if(empty($errores)) {
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email' ";
            $resultado = mysqli_query($db, $query); //devuelve un objeto

            if($resultado->num_rows) {  //num_rows da 1 si existe el usuario, sino devuelve 0. Con la flecha accedo a una propiedad de un objeto

                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario["password"]); 
                
                if($auth) { //si el email y la contraseña son iguales a la de la bd
                    session_start();    //inicio sesion
                    $_SESSION["usuario"] = $usuario["email"];   //en la variable superglobal $_SESSION puedo guardar el dato que quiera y se puede acceder a ella desde cualquier parte del proyecto, siempre y cuando se llame a la funcion session_start(). Las propiedades las invento yo
                    $_SESSION["login"] = true;

                    header("Location: /admin");
                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El usuario no existe";
            }
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