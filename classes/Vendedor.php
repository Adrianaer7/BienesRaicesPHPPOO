<?php 
    namespace App;

    class Vendedor extends ActiveRecord {
        protected static $tabla = "vendedores";
        protected static $columnasDB = ["id", "nombre", "apellido", "telefono"];

        public $id;
        public $nombre;
        public $apellido;
        public $telefono;

        public function __construct($args = []) //$args es el array $_POST que le paso a la instancia de esta clase
        {
            $this->id = $args["id"] ?? null;
            $this->nombre = $args["nombre"] ?? "";
            $this->apellido = $args["apellido"] ?? "";
            $this->telefono = $args["telefono"] ?? "";
        }
    }
    
?>