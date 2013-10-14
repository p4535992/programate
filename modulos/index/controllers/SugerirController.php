<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './lib/Controller.php';
include_once './lib/RoviAPI.php';
include_once './modulos/index/models/MovieModel.php';

/**
 * Description of SugerirController
 *
 * @author Andres
 */
class SugerirController extends Controller {

    private $nombre = "index";

    //put your code here

    /**
     * 
     */
    public function mispreferencias() {
        //verifica si inicio sesion
        if ($this->isLoggedIn()) {
            $peliculas = $this->getPeliculas();
            $programas = $this->getProgramasTelevision();


            $pathtoVista = "./modulos/$this->nombre/views/index.php";
            $view = parent::cargarVista($pathtoVista, 'index', array("peliculas" => $peliculas, 'programas' => $programas));
            parent::renderizarPagina($view->getHTML('sugerir'), $view->getParametros());
        } else {
            header("Location: /index/home/index");
        }
    }

    /**
     * 
     * @return type
     */
    public function getPeliculas() {
        $accessToken = $_COOKIE["programate"];
        //se obtiene informacion de gustos de peliculas del usuario, desde facebook.
        $json = json_decode(file_get_contents("https://graph.facebook.com/me/movies?access_token=" . $accessToken), true);

        //a continuacion se debera obtener informacion mas detallada de las peliuclas que le gustan.
        //para ello se accedera a la API de Rovi
        $roviAPI = new RoviAPI();
        $movieModel = new MovieModel();

        foreach ($json['data'] as $key => $peli) {
            $nombrePeli = $peli['name'];
            //se reemplaza lso espacios del nombre por +;
            $nombrePeli = str_replace(" ", "+", $nombrePeli);
            $roviRespuesta = $roviAPI->movieInfo($nombrePeli);

            //verificamos si la respuesta a la consulta es correcta.
            if ($roviRespuesta['code'] == 200) {
                //la respuesta fue correcta
             
                $movieModel->cargarPeliculas($roviRespuesta['video']);
                
            } else {
                continue;
                
            }
        }

        // return $json['data'];//aun falta obtener las peliculas como tal.
        return $movieModel->getArrayMovies();
    }

    public function getProgramasTelevision() {
        $accessToken = $_COOKIE["programate"];
        $json = json_decode(file_get_contents("https://graph.facebook.com/me/television?access_token=" . $accessToken), true);
        return $json['data']; //aun falta obtener los programas de tv como tal.
    }

}

?>
