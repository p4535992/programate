<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author Andres
 */
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
       return "modulos/rovi/views/layout/$vista.phtml";
    }
    
    public function getCSS(){
        
    } 
    

}

?>
