<?php

//Incluimos la configuracion con las rutas de las demas librerias
require_once 'conf/config.php';
require_once 'Aplicacion.php';
/**
 * Clase de entrada de la aplicacion
 */
class FrontController {

    /**
     * Punto de entrada de la aplicacion
     */
    public static function manejadorPeticiones() {
        $app = Aplication::getInstance();
        $app->manejadorErrores();
        $app->manejadorExcepciones();


        $modulo = (!empty($_REQUEST['modulo'])) ? $_REQUEST['modulo'] : 'index';
        $contro = (!empty($_REQUEST['controlador'])) ? $_REQUEST['controlador'] : 'home';
        $metodo = (!empty($_REQUEST['metodo'])) ? $_REQUEST['metodo'] : 'index';


        /**
         * Verifica que el modulo exista.
         */
        if ($app->verificarModulo($modulo)) {
            $controlador = $app->cargarControlador($modulo, $contro);
            if ($controlador === null) {
              $app->error(404, "No se encontro el controlador Pedido, verifique los parametros", "Error de URL");
            } else {
                       
                if ($app->verificarMetodo($controlador,$metodo)) {
                    $controlador->$metodo();
                }else{
                    $app->error(404, "No se encontro la accion Pedida, verifique los parametros", "Error de URL");
                }
            }
        } else {
            $app->error(404, "No se encontro el modulo Pedido, verifique los parametros", "Error de URL");
        }
    }

}

FrontController::manejadorPeticiones();
?>
