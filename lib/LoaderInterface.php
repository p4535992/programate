<?php

interface LoaderInterface {
    
    function cargarHeader();
    
    function cargarContenido($vistaHTML, $parametros);
    
    function cargarFooter();
    
    function cargarLoginFacebook();
        
}
?>
