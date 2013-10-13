<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelInterface
 *
 * @author Andres
 */
interface ModelInterface {
    
    function insertar($entidad); 
    function actualizar($entidad);
    function eliminar($entidad);
    function consultar($nombreEntidad, $id);
    function crearConexionMysql();
    function cerrarConexionMysql();
}

?>
