<?php
declare(strict_types=1);

define("TEMPLATES_URL", __DIR__ . "/templates");    //__DIR__ es una funcion de php que trae toda la ruta anterior a templates. A la ruta le agrego el nombre TEMPLATES_URL para que sea mas facil importarla
define("FUNCIONES_URL", __DIR__ . "/funciones.php");
define("CARPETA_IMAGENES", __DIR__ . "../../imagenes/");

function incluirTemplate(string $nombre, string $pagina = "Bienes Raices", bool $inicio = false ) {    //importo de cada pagina el nombre de lo que quiero importar. Lo uso para importar header y footer. Si inicio me llega como true, agrego la clase inicio al header
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estadoAutenticado() : bool {
    session_start();
    //Verificar usuario autenticado
    if(!$_SESSION["login"]) {
        header("Location: /");
    }
    return true;
}

function debugear($variable) {
    echo '<pre>';
        var_dump($variable);
    echo '</pre>';
    exit;
}

//Escapar/Sanitizar el html
function s($html) {
    $s = htmlspecialchars($html);
    return $s;
}