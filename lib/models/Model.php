<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './lib/models/ModelInterface.php';
include_once './lib/models/Entity.php';
/**
 * es la clase padre que heredaran los demas modelos, con unas funciones basicas de cada uno
 * CRUDS.
 *
 * @author Andres
 */
class Model implements ModelInterface{
    
    function __construct() {
        
    }

    public function actualizar( $entidad) {
        
    }

    public function consultar($nombreEntidad, $id) {
        
    }

    public function eliminar( $entidad) {
        
    }

    public function insertar( $entidad) {
        
    }

    public function cerrarConexionMysql() {
        
    }

    public function crearConexionMysql() {
        
    }
    
    
   
    
}

?>
