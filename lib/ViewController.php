<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewController
 *
 * @author Andres
 */
class ViewController {
    private $parametros;

    public function getParametros() {
        return $this->parametros;
    }

    public function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    public function getHTML($modulo, $vista = 'default') {       
       return "modulos/$modulo/views/layout/$vista.phtml";
    }
    
    public function getCSS(){
        
    }
}

?>
