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

    function cargarVista($ruta, $vistaModulo, $parametros = null) {
        include $ruta;
        $clase = ucfirst(strtolower($vistaModulo)) . "ViewController";
        $view = new $clase();
        $view->setParametros($parametros);
        return $view;
    }

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

}

?>