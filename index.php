<?php

//Incluimos la configuracion con las rutas de las demas librerias
require_once 'conf/config.php';
require_once 'Aplicacion.php';

/**
 * Clase de entrada de la aplicacion
 */
class FrontController {

    private $basePath = "";
    private $modulo = "index";
    private $controlador = "home";
    private $metodo = "index";

    /**


     * Punto de entrada de la aplicacion
     */
    public function manejadorPeticiones() {
       // session_start();
        $app = Aplication::getInstance();
        $app->manejadorErrores();
        $app->manejadorExcepciones();

        $this->parseUri();

        /*         * $modulo = (!empty($_REQUEST['modulo'])) ? $_REQUEST['modulo'] : 'index';
          $contro = (!empty($_REQUEST['controlador'])) ? $_REQUEST['controlador'] : 'home';
          $metodo = (!empty($_REQUEST['metodo'])) ? $_REQUEST['metodo'] : 'index';
         */

        /**
         * Verifica que el modulo exista.
         */
        if ($app->verificarModulo($this->modulo)) {
            $controlador = $app->cargarControlador($this->modulo, $this->controlador);
            if ($controlador === null) {
                $app->error(404, "No se encontro el controlador Pedido, verifique los parametros", "Error de URL");
            } else {

                if ($app->verificarMetodo($controlador, $this->metodo)) {
                    $metodo = $this->metodo;
                    $controlador->$metodo();
                } else {
                    $app->error(404, "No se encontro la accion Pedida, verifique los parametros", "Error de URL");
                }
            }
        } else {
            $app->error(404, "No se encontro el modulo Pedido, verifique los parametros", "Error de URL");
        }
    }

    protected function parseUri() {
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

        //$path = preg_replace('/[^a-zA-Z0-9]/', "", $path);
        /* if (strpos($path, $this->basePath) === 0) {
          $path = substr($path, strlen($this->basePath));
          } */

        try {
            @list($module, $controller, $action) = explode("/", $path, 3);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        if (isset($module) && $module != null) {
            $this->setModulo($module);
        }
        if (isset($controller) && $controller != null) {
            $this->setControlador($controller);
        }
        if (isset($action) && $action != null) {
            $this->setMetodo($action);
        }
    }

    public function getBasePath() {
        return $this->basePath;
    }

    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    public function getControlador() {
        return $this->controlador;
    }

    public function setControlador($controlador) {
        $this->controlador = $controlador;
    }

    public function getMetodo() {
        return $this->metodo;
    }

    public function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

}

$Frontcontrolador = new FrontController();
$Frontcontrolador->manejadorPeticiones();
?>
