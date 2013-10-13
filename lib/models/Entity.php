<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entidad
 *
 * @author Andres
 */
class Entity {
   
    private $nombre;
    private $data = array();
    
    function __construct($nombre, $data) {
        $this->nombre = $nombre;
        $this->data = $data;
    }

    
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }


}

?>
