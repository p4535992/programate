<?php
include_once './lib/Controller.php';
/**
 * Controlador de la pagina inicial de la aplicacion.
 */
class HomeController extends Controller {
    /**
     *
     * @var type String, Nombre del controlador.
     */
    private $nombre;
    /**
     * 
     * @param type $nombre, nombre del controlador 
     */
    public function __construct($nombre='Home') {
        $this->nombre = $nombre;
    }

    /**
     * Funcion inicial de  la aplicacion
     * @param type $parametros, parametros a ser enviados a la pagina web.
     */
    public function index($parametros = NULL) {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $parametros = array('mensaje' => "hola mundo", 'titulo'=>"Programate");
        $view = parent::cargarVista($pathtoVista, 'index', $parametros);
        parent::renderizarPagina($view->getHTML(), $view->getParametros());
    }

}
?>
