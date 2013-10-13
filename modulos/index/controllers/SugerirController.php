<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './lib/Controller.php';

/**
 * Description of SugerirController
 *
 * @author Andres
 */
class SugerirController extends Controller {

    private $nombre = "index";

    //put your code here


    public function mispreferencias() {
        //verifica si inicio sesion
        if ($this->isLoggedIn()) {
            $peliculas = $this->getPeliculas();
            return $peliculas;
        } else {
            header("Location: /index/home/index");
        }
    }

    public function getPeliculas() {
        if (isset($_COOKIE["programate"])) {
            $accessToken = $_COOKIE["programate"];
            $json = file_get_contents("https://graph.facebook.com/me/movies?access_token=" . $accessToken);
            $pathtoVista = "./modulos/$this->nombre/views/index.php";
            $view = parent::cargarVista($pathtoVista, 'index', array("json" => $json));
            parent::renderizarPagina($view->getHTML('sugerir'), $view->getParametros());
        }else{
            
            
        }
    }

}

?>
