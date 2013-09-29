<?php
include_once 'handlers/manejador.php';
class  Aplication{
     private static $instancia;
    function Aplicacion($version = "") {
        $this->version = $version;
    }
    
   public static function getInstance()
   {
      if (  !self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }
    
    //Este metodo carga los controladores segun el nombre
    // Busca los controladores en los paquetes
    function cargarControlador($modulo,$controlador) {
        $controlador = strtolower($controlador);
        
        $urlFile = 'modulos/'.$modulo.'/controllers/' . $controlador . 'Controller.php';
        echo $urlFile;
        if (file_exists($urlFile)) {
            include $urlFile;
            $class = $controlador.'Controller';
            $controller = new $class($modulo);
            return $controller;
        } else {
            return null;
        }
    }
    
     
   
    //Si ocurre algun error devuelve el error con el tipo
    function error($mensaje = "Ocurrio un error inesperado!", $titulo = "Error del sistema") {
        
    }
    
        /**
     * 
     */
    public static function manejadorErrores(){
        set_error_handler('manejarErrores');
    }
    
    /**
     * 
     */
    public static function manejadorExcepciones(){
     
        
    }
    
}
