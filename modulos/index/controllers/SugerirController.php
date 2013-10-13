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
            $programas = $this->getProgramasTelevision();
            
            
            $pathtoVista = "./modulos/$this->nombre/views/index.php";
            $view = parent::cargarVista($pathtoVista, 'index', array("peliculas" => $peliculas, 'programas'=>$programas));
            parent::renderizarPagina($view->getHTML('sugerir'), $view->getParametros());
        } else {
            header("Location: /index/home/index");
        }
    }

    public function getPeliculas() {
        $accessToken = $_COOKIE["programate"];
        $json = json_decode(file_get_contents("https://graph.facebook.com/me/movies?access_token=" . $accessToken), true);
        return $json;//aun falta obtener las peliculas como tal.
    }
    
    public function getProgramasTelevision(){
         $accessToken = $_COOKIE["programate"];
        $json = json_decode(file_get_contents("https://graph.facebook.com/me/television?access_token=" . $accessToken), true);
        return $json;//aun falta obtener los programas de tv como tal.
    }

}

?>
