<?php

class IndexViewController {

    private $parametros;

    public function getParametros() {
        return $this->parametros;
    }

    public function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    public function getHTML() {
        switch ($this->parametros["error"]) {
            case 404:
                return './modulos/errores/views/layout/404.phtml';
                break;
            case 503:
                return './modulos/errores/views/layout/404.phtml';
                break;
            case 500:
                 return './modulos/errores/views/layout/500.phtml';
                break;
            default:
                return './modulos/errores/views/layout/default.phtml';
                break;
        }
    }

    public function getCSS() {
        
    }

}

?>