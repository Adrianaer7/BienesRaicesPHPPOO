<?php 
    namespace App;

    class Vendedor extends ActiveRecord {
        protected static $tabla = "vendedores";
        protected static $columnasDB = ["id", "nombre", "apellido", "telefono"];
    }
    
?>