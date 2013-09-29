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
     * constructor de la clase.
     */
    public function __construct() {
        $this->nombre = 'errores' ;
        $this->template = TEMPLATE;
    }

    /**
     * Metodo encargado de procesar los errores y enviarlos a la pagina principal
     * @param type $msg,  Mensaje personalizado
     * @param type $tituloPagina, String con el titulo de la pagina
     * @param type $codError, Int codigo del error generado y a ser mostrado.
     */
    public function procesarError($msg, $tituloPagina, $codError = 0) {
        switch ($codError) {
            case 404:
                $pathtoVista = "./modulos/$this->nombre/views/404.phtml";
                break;

            case 503:
                $pathtoVista = "./modulos/$this->nombre/views/503.phtml";
                break;

            case 500:
                $pathtoVista = "./modulos/$this->nombre/views/500.phtml";
                break;

            //error por defecto en caso de no coincidir
            default :
                $pathtoVista = "./modulos/$this->nombre/views/default.phtml";
                break;
        }
        $parametros = array('error' => $codError, 'titulo' => $tituloPagina, 'mensaje' => $msg);
        parent::asignar(array('contenido' => $pathtoVista, 'params' => $parametros));
        parent::cargarVista('index', $parametros);
    }
    /**
     * Funcion encargada de registrar el error en los Log.
     * @param type $codError, Int Codigo del error HTTP
     * @param type $data, Arreglo con la informacion a ser registrada en el Log.
     */
    public function registrarError($codError, $data){
        error_log($data, 3, './logs/errorlogs.log');
    }

}

?>
