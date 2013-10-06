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
    public function __construct($nombre = 'Home') {
        $this->nombre = $nombre;
    }

    /**
     * Funcion inicial de  la aplicacion
     * @param type $parametros, parametros a ser enviados a la pagina web.
     */
    public function index($parametros = NULL) {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $parametros = array(
            'programa1' => array('titulo' => 'Desafio Africa (El Origen)', 'info' => "Décima temporada del reality show colombiano, Desafío.
            El programa fue estrenado el día lunes 13 de mayo de 2013"),
            'programa2' => array('titulo' => 'Suso', 'info' => "Décima temporada del reality show colombiano, Desafíoasdasdasdasddas"),
            'programa3' => array('titulo' => 'MBD', 'info' => "Décima temporada del reality show colombiano, Desafíoasdasdasdasd"),
            'cant' => 3
            , 'titulo' => "Programate");
        $view = parent::cargarVista($pathtoVista, 'index', $parametros);
        parent::renderizarPagina($view->getHTML(), $view->getParametros());
    }

    public function ayuda() {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', null);
        parent::renderizarPagina($view->getHTML('ayuda'), $view->getParametros());
    }

    public function programar() {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', null);
        parent::renderizarPagina($view->getHTML('programar'), $view->getParametros());
    }

  

    public function cine() {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', null);
        parent::renderizarPagina($view->getHTML('cine'), $view->getParametros());
    }

    public function sugerir() {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', null);
        parent::renderizarPagina($view->getHTML('sugerir'), $view->getParametros());
    }

    public function donacion() {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', null);
        parent::renderizarPagina($view->getHTML('donacion'), $view->getParametros());
    }

}

?>
