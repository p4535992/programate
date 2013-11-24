<?php

include_once './lib/ViewController.php';
class FavoritosViewController extends ViewController{

    private $parametros;

    public function getParametros() {
        return $this->parametros;
    }

    public function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    public function getHTML($vista = 'listafavoritos') {       
       return "modulos/rovi/views/layout/$vista.phtml";
    }
    
    public function getCSS(){
        
    }    

}