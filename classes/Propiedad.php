<?php 
    namespace App;

    class Propiedad extends ActiveRecord {
        protected static $tabla = "propiedades";
        protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "estacionamiento", "creado", "vendedores_id"];
    }
    
?>