<?php

declare(strict_types=1);

require "app.php";

function incluirTemplate(string $nombre, string $pagina = "Bienes Raices", bool $inicio = false ) {    //importo de cada pagina el nombre de lo que quiero importar. Lo uso para importar header y footer. Si inicio me llega como true, agrego la clase inicio al header
    include TEMPLATES_URL . "/{$nombre}.php";
}