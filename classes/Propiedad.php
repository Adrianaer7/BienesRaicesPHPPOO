<?php 
    namespace App;

    class Propiedad {

        //BD
        protected static $db;   //protected porque solo se puede acceder a ella en la clase. Static porque no se va a crear una instancia por cada objeto nuevo, la conexion a la bd siempre es con las mismas credenciales. Esto ahorra ram
        protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "estacionamiento", "creado", "vendedores_id"];

        //Errores
        protected static $errores = [];

        public $id;
        public $titulo;
        public $precio;
        public $imagen;
        public $descripcion;
        public $habitaciones;
        public $wc;
        public $estacionamiento;
        public $creado;
        public $vendedores_id;

        //Definir la conexion a la BD
        public static function setDB($database) {   //recibo $dabatase del app.php que es donde se ejecuta este metodo
            self::$db = $database;  //con self:: envio database a la variable estatica que hay en la clase 
        }

        public function __construct($args = []) //$args es el array $_POST que le paso a la instancia de esta clase
        {
            $this->id = $args["id"] ?? "";
            $this->titulo = $args["titulo"] ?? "";
            $this->precio = $args["precio"] ?? "";
            $this->imagen = $args["imagen"] ?? "";
            $this->descripcion = $args["descripcion"] ?? "";
            $this->habitaciones = $args["habitaciones"] ?? "";
            $this->wc = $args["wc"] ?? "";
            $this->estacionamiento = $args["estacionamiento"] ?? "";
            $this->creado = date("Y/m/d");
            $this->vendedores_id = $args["vendedores_id"] ?? "";
        }

        public function guardar() {
            //Guardar valores sanitizados
            $atributos = $this->sanitizarAtributos();   //ejecuto la funcion de sanitizar y con this-> accedo a los valores que me retorna esa funcion, a esos valores los guardo en atributos
            
            //Insertar en la BD
            $query = "INSERT INTO propiedades (";
            $query .= join(', ', array_keys($atributos));   //con el .= concateno en un string lo que haya en este renglon más lo que habia en el anterior. Join es como split de js. array_keys son las llaves o columnas del array atributos
            $query .= ") VALUES ('";
            $query .= join("', '", array_values($atributos));   //array_values son los valores de las columnas
            $query .= "')";

            $resultado = self::$db->query($query);  //resultado devuelve true. Con db->query accedo al metodo que forma parte de la instancia de mysqli y sirve para hacer la consulta
            return $resultado;
        }

        //Identificar y unir los atributos de la BD
        public function atributos() {
            $atributos = [];
            foreach(self::$columnasDB as  $columna) {
                if($columna === "id") continue; //al id no hay que sanitizarlo, por eso no lo guardo en el array atributos. El continue hace que no se ejecute lo que esté debajo, y el foreach siga con el siguiente elemento
                $atributos[$columna] = $this->$columna; //$this es la instancia del objeto en memoria, en este caso (propiedad) y $columna es el valor que contiene la columna de ese $this, seria asi: $propiedad["Casa en la playa"]. A esto se lo agrego al array atributo, el cual en cada columna ($atributos["nombre]) va recibiendo $propiedad["Casa en la playa"].
            }
            return $atributos;
        }

        public function sanitizarAtributos() {
            $atributos = $this->atributos();
            $sanitizado = [];

            foreach($atributos as $key => $value ) {    //key es el nombre de la columna, value es el valor que almacena esa columna
                $sanitizado[$key] = self::$db->escape_string($value);   //sanitizo cada valor
            }
            return $sanitizado;
        }

        //Validacion
        public static function getErrores() {
            return self::$errores;
        }

        public function validar() {
            if(!$this->titulo) {
                self::$errores[] = "El titulo es obligatorio";
            }
            if(!$this->precio) {
                self::$errores[] = "El precio es obligatorio";
            }
            if(strlen($this->descripcion) < 50) {
                self::$errores[] = "La descripcion es obligatoria y tiene que tener como minimo 50 caracteres";
            }
            if(!$this->habitaciones) {
                self::$errores[] = "El numero de habitaciones es obligatorio";
            }
            if(!$this->wc) {
                self::$errores[] = "El numero de baños es obligatorio";
            }
            if(!$this->estacionamiento) {
                self::$errores[] = "La capacidad del garage es obligatorio";
            }
            if(!$this->vendedores_id) {
                self::$errores[] = "El nombre del vendedor es obligatorio";
            }
            if(!$this->imagen) {
                self::$errores[] = "La imagen es obligatoria";
            }
            return self::$errores;
        }

        //Subida de archivos
        public function setImagen($imagen) {
            //Asignar al atributo de imagen el nombre de la imagen
            if($imagen) {
                $this->imagen = $imagen;
            }
        }

        //Listar todas las propiedades
        public static function all() {
           $query = "SELECT * FROM propiedades";
           //Consulto la bd y cambio el array con arrays asociativos que me devuelve sql, por un array de objetos
           $resultado = self::consultarSQL($query);

           //Envio el resultado al index
           return $resultado;
        }

        public static function consultarSQL($query) {   //traigo el string
            //Consultar la BD
            $resultado = self::$db->query($query);

            //Iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()) {  //por cada elemento que hay en $resultado
                $array[] = self::crearObjeto($registro);    //lo inserto en el array en forma de objeto
            }
            
            //Liberar memoria
            $resultado->free();

            //Retornar los resultados
            return $array;
        }

        protected static function crearObjeto($registro) {
            $objeto = new self; //crea nuevos objetos de la clase actual con sus propiedades vacias. Es como crear una nueva instancia. ACtiveRecord trabaja con objetos no con arreglos asociativos para agrupar las propiedades
            foreach($registro as $key => $value) {  //recorro el array asociativo
                if(property_exists($objeto, $key)) {    //si existe propiedad
                    $objeto->$key = $value; //le asigno el valor que hay en el array asociativo a la columna del objeto
                }
            }
            return $objeto;
        }
    }
    
?>