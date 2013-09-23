<?php

//Incluimos la configuracion con las rutas de las demas librerias
require_once 'conf/config.php';
include_once 'handlers/manejador.php';
require_once 'Aplicacion.php';

class FrontController {

    /**
     * 
     */
    public static function manejadorPeticiones() {
        $this->manejadorErrores();
        $this->manejadorExcepciones();
        $app = Aplication::getInstance(); 
        
        
        $modulo =  (!empty($_REQUEST['modulo'])) ? $_REQUEST['modulo'] : 'index';
        $contro =  (!empty($_REQUEST['controlador'])) ? $_REQUEST['controlador'] : 'home';
        $metodo = (!empty($_REQUEST['metodo'])) ? $_REQUEST['metodo'] : 'index';
        
        $controlador = $app->cargarControlador($modulo, $contro);
        
        if ($controlador === null) {
            echo 'error';
            $app->error("No se encontro el controlador. " . $controlador . ".");
        } else {
            // equivalente // call_user_func(array($cont, $action));
            $controlador->$metodo();
            
        }
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

FrontController::manejadorPeticiones();
?>
