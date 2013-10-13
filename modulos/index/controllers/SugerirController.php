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

    //put your code here


    public function mispreferencias() {
        //verifica si inicio sesion
        if ($this->isLoggedIn()) {
            $peliculas = $this->getPeliculas();
            return $peliculas;
        }else{
            header("Location: /index/home/index");
        }
        
    }
    
    public function getPeliculas(){
        $accessToken = $_COOKIE["programate"];
        $json = file_get_contents("https://graph.facebook.com/me/movies?access_token=".$accessToken);
        
    }

}

?>
