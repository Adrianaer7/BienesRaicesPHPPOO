<?php
require "funciones.php";    //importo funciones
require "config/database.php";  //importo bd
require __DIR__ . "/../vendor/autoload.php";    //importo clases

//Conectar DB
$db = conectarDB();

use App\Propiedad;

Propiedad::setDB($db);  //Con Propiedad:: puedo ejecutar metodos que estén en la clase Propiedad fuera del archivo donde se declara la clase. Envio la $db al metodo estatico de la clase
