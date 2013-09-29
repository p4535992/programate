<?php

class Controller {

    function asignar($array) {
        foreach ($array as $key => $value) {
            $_POST[$key] = $value;
        }
    }

    function cargarModelo($modelo) {
        $modelo = ucfirst(strtolower($modelo));
        $modelo = './models/' . $modelo . 'Model.php';
        if (file_exists($modelo)) {
            require_once $modelo;
            return true;
        } else {
            return false;
        }
    }
    
    function cargarVista($vista='index', $parametros=null){
        //lo Primero que se hara es cargar el template.
        
        $path = TEMPLATEURI.TEMPLATE.'/template.phtml';
        if (file_exists($path)) {  
            require_once $path;
            return true;
        } else {
            return false;
        }
        
        
    }
    

}

?>