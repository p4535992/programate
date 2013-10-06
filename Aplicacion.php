<?php

include_once 'handlers/manejador.php';
include_once 'modulos/errores/controllers/ErrorController.php';

class Aplication {
    
    /**
     *
     * @var type Aplicacion, reservado para el patron de diseno Singleton
     */
    private static $instancia;
    /*
     * contructor de la clase.
     */
    function Aplicacion($version = "") {
        $this->version = $version;
    }
    /*
     * Patron de diseño Singleton
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

}
