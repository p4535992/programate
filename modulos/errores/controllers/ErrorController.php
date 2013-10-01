<?php

include_once './lib/Controller.php';

/**
 * Clase encargada del manejo de los errores
 */
class ErrorController extends Controller {

    /**
     *
     * @var type 
     */
    private $template = '';
    private $nombre = 'errores';

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        $this->nombre = 'errores';
        $this->template = TEMPLATE;
    }

    /**
     * Metodo encargado de procesar los errores y enviarlos a la pagina principal
     * @param type $msg,  Mensaje personalizado
     * @param type $tituloPagina, String con el titulo de la pagina
     * @param type $codError, Int codigo del error generado y a ser mostrado.
     */
    public function procesarError($msg, $tituloPagina, $codError = 0) {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $parametros = array('error' => $codError, 'titulo' => $tituloPagina, 'mensaje' => $msg);
        parent::asignar(array('contenido' => $pathtoVista, 'params' => $parametros));
        $view = parent::cargarVista($pathtoVista, 'index', $parametros);
        parent::renderizarPagina($view->getHTML(), $view->getParametros());
    }

    /**
     * Funcion encargada de registrar el error en los Log.
     * @param type $codError, Int Codigo del error HTTP
     * @param type $data, Arreglo con la informacion a ser registrada en el Log.
     */
    public function registrarError($codError, $mensaje) {
        error_log($this->obtenerRegistro($codError, $mensaje), 3, './logs/errorlogs.log');
    }

    public function obtenerRegistro($codError, $mensaje) {
        $ip = $this->obtenerIPEntrante();
        return "La IP: $ip Genero el error $codError $mensaje \n";
    }

    /**
     * @return string, IP entrante
     */
    public function obtenerIPEntrante() {
        $ipaddress = '';
        try {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if (getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv ('HTTP_X_FORWARDED_FOR');
            else if (getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if (getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if (getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if (getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';

            return $ipaddress;

            return $ipaddress;
        } catch (Exception $e) {
            
        }
    }

}

?>
