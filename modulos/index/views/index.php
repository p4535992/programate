<?php
include_once './lib/ViewController.php';
class IndexViewController extends ViewController{

    private $parametros;

    public function getParametros() {
        return $this->parametros;
    }

    public function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    public function getHTML($vista = 'default') {       
       return "modulos/index/views/layout/$vista.phtml";
    }
    
    public function getCSS(){
        
    }
    
    

}
?>