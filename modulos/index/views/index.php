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
        
       return 'modulos/index/views/layout/default.phtml';
    }
    
    public function getCSS(){
        
    }
    
    

}
?>