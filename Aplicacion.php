<?php

include_once 'handlers/manejador.php';
include_once 'modulos/errores/controllers/ErrorController.php';

class Aplication {

    /**
     *
     * @var type Aplicacion, reservado para el patron de diseno Singleton
     */
    private static $instancia;
    private static $mysql;

    /*
     * contructor de la clase.
     */

    function Aplicacion($version = "") {
        $this->version = $version;
    }

    /*
     * Patron de diseÃ±o Singleton
     */

    public static function getInstance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    /**
     * Este metodo carga los controladores segun el nombre
     * y el modulo al que pertenesca.
     */
    function cargarControlador($modulo, $controlador) {
        $controlador = ucfirst(strtolower($controlador));
        $modulo = strtolower($modulo);
        $urlFile = 'modulos/' . $modulo . '/controllers/' . $controlador . 'Controller.php';

        if (file_exists($urlFile)) {
            include $urlFile;
            $class = $controlador . 'Controller';
            $controller = new $class($modulo);
            return $controller;
        } else {
            return null;
        }
    }

    /**
     * Esta funcion ejecuta una serie de errores determinados.
     * @param type $codError tipo de error HTTP
     * @param type $mensaje, Mensaje personalizado del error
     * @param type $titulo, Titulo de la pagina web donde aparecera el error.
     */
    function error($codError, $mensaje = "Ocurrio un error inesperado!", $titulo = "Error del sistema") {
        $erroController = new ErrorController();
        $erroController->procesarError($mensaje, $titulo, $codError);
        $erroController->registrarError($codError, $mensaje);
    }

    /**
     * funcion encargada de setear el manejador de errores
     */
    public static function manejadorErrores() {
        set_error_handler('manejarErrores');
    }

    /**
     *  funcion encargada de setear el manejador de excepciones
     */
    public static function manejadorExcepciones() {
        
    }

    /**
     * 
     * @param type $modulo, String que indica el modulo a verificar su existencia
     * @return type boolean, Respuesta si existe o no el modulo en la app.
     */
    public function verificarModulo($modulo) {
        return file_exists("./modulos/" . $modulo);
    }

    /**
     * 
     * @param type $controlador
     * @param type $metodo
     * @return type boolean 
     */
    public function verificarMetodo($controlador, $metodo) {
        return method_exists($controlador, $metodo);
    }

    /**
     * 
     * @param type $param
     * @return \mysqli
     */
    public static function crearConexionSQL($param) {
        // mysqli
        try {
            if (!self::$mysql instanceof mysqli) {
                self::$mysql = new mysqli("localhost", "root", "123456", "programate");
            }
            return self::$mysql;
        } catch (Exception $e) {
            
        }
    }

    /**
     * 
     * @param type $atributos
     * @param type $from
     * @param type $where
     * @param type $extras
     */
    public static function select($atributos, $tablas, $where, $extras = "") {
        $mysql = Aplication::crearConexionSQL(NULL);
        $query = "SELECT $atributos FROM $tablas WHERE $where $extras";
        $resultado = $mysql->query($query);
        if ($resultado != null) {
            $fila = $resultado->fetch_assoc();
            return $fila;
        } else {
            return null;
        }
    }

    /**
     * 
     * @param type $query
     * @return type
     */
    public static function selectQuery($query) {
        $mysql = Aplication::crearConexionSQL(NULL);
        $resultado = $mysql->query($query);
        return $resultado;
    }

    /**
     * 
     * @param type $param
     */
    public static function update($param) {
        
    }

    /**
     * 
     * @param type $tabla
     * @param array $atributos
     * @return type
     */
    public static function insert($tabla, array $atributos) {
        try {
            $mysql = Aplication::crearConexionSQL(NULL);
            $coma = "";
            $columnas = "";
            $valores = "";
            foreach ($atributos as $key => $value) {
                $columnas.=$coma . $key;

                if (is_integer($value)) {
                    $valores.=$coma . $value;
                } else
                if (is_string($value)) {
                    $valores.=$coma . "'" . $value . "'";
                } else {
                    $valores.=$coma . $value;
                }
                $coma = ",";
            }
            $query = "INSERT INTO $tabla ($columnas) VALUES ($valores);";

            $resultado = $mysql->query($query);
           // var_dump($resultado);
           // var_dump($query);
        } catch (Exception $e) {
            var_dump($e->getTraceAsString());
        }
        return $resultado;
    }

    /**
     * 
     * @param type $tabla
     * @param type $condiciones
     * @return type
     */
    public static function delete($tabla, $condiciones) {
        $mysql = Aplication::crearConexionSQL(NULL);
        $query = "DELETE FROM $tabla WHERE $condiciones";
        $resultado = $mysql->query($query);
        return $resultado;
    }

    /**
     * 
     * @param type $usuario
     * @return boolean
     */
    public static function existeUsuario($usuario) {
        $fila = Aplication::select('username', 'usuario', "username='" . $usuario['username'] . "'");
        if ($fila == null && $fila['username'] == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 
     * @param type $usuario
     */
    public static function agregarUsuario($usuario) {
        Aplication::insert("usuario", $usuario);
    }

}
