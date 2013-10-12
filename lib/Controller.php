<?php

/**
 * 
 */
class Controller {

    /**
     * 
     * @param type $array
     */
    function asignar($array) {
        foreach ($array as $key => $value) {
            $_POST[$key] = $value;
        }
    }

    /**
     * 
     * @param type $modelo
     * @return boolean
     */
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

    /**
     * 
     * @param type $ruta
     * @param type $vistaModulo
     * @param type $parametros
     * @return \clase
     */
    function cargarVista($ruta, $vistaModulo, $parametros = null) {
        include $ruta;
        $clase = ucfirst(strtolower($vistaModulo)) . "ViewController";
        $view = new $clase();
        $view->setParametros($parametros);
        return $view;
    }

    /**
     * 
     * @param type $vista
     * @param type $parametros
     */
    function renderizarPagina($vista, $parametros) {
        $path = TEMPLATEURI . TEMPLATE . '/Loader.php';
        if (file_exists($path)) {
            include $path;
            $loader = new Loader();
            $loader->cargarContenido($vista, $parametros);
            $loader->rederizarPagina();
            // return true;
        } else {
            // error 404
            // return false;
        }
    }

    function ejecutarCURL($url) {
        $ch = curl_init($url);
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        // add useragent 
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return curl_exec($ch);
    }

}

?>