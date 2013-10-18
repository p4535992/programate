<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './lib/models/Modelo.php';
include_once './lib/models/Entity.php';

/**
 * Description of MovieModel
 *
 * @author Andres
 */
class MovieModel extends Modelo {

    private $arrayMovies = array();

    /**
     * Es un Json de Rovi basado en la API de Busquedas
     * http://developer.rovicorp.com/docs
     * @param type $roviJSON
     */
    public function cargarPeliculas($value) {
        $data = array();
        //value equivale a una pelicula.        
        //foreach ($roviJSON as $key => $value) 
            {
           // $data['tipo'] = $value['type'];
          //  $data['idPelicula'] = $value['id'];
            $data['iGuideId'] = $value['ids']['iguideId'];
            $data['titulo'] = $value['masterTitle'];
            $data['titulosecudario'] = $value['secondaryTitle'];
            $data['titulomaestro'] = $value['masterTitle'];
            $data['categoria'] = $value['category'];
            $data['subcategoria'] = $value['subcategory'];
            $data['idioma'] = $value['programLanguage'];
            $data['clipUri'] = $value['clipUri'];
            $data['relatedUri'] = $value['relatedUri'];
          // $data['webUri'] = $value['webUri'];
            $data['imagen'] = $value['images'][0]['url'];
            $pelicula = new Entity('Movie', $data);
            
            $this->arrayMovies[] = $pelicula;
        }
    }
/**
 * 
 * @return type
 */
    public function getArrayMovies() {
        return $this->arrayMovies;
    }
/**
 * 
 * @param type $arrayMovies
 */
    public function setArrayMovies($arrayMovies) {
        $this->arrayMovies = $arrayMovies;
    }

}

?>
