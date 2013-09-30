<?php
include './lib/LoaderInterface.php';
class Loader implements LoaderInterface {

    private $footerHTML;
    private $contenidoURL;
    private $headerHTML;
    private $loginHTML;
    private $menuHTML;
    private $parametros = array();

    function __construct() {
        $this->cargarHeader();
        $this->cargarFooter();
        $this->cargarLoginFacebook();
        $this->cargarMenu();
    }

    public function cargarContenido($vistaURL, $parametros) {
        $this->contenidoURL = $vistaURL;
        $this->parametros = array_merge((array)$parametros, $this->parametros);
    }

    public function cargarFooter() {
        //carga el modulo de Footer
    }

    public function cargarHeader() {
        //carga el modulo de header
    }

    public function cargarLoginFacebook() {
        //carga el modulo login de facebook.
    }

    public function cargarMenu() {
        
    }

    public function rederizarPagina() {
        
        require TEMPLATEURI.TEMPLATE.'/template.phtml';
    }

}

?>
