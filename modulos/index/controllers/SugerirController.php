<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once './lib/Controller.php';
include_once './lib/RoviAPI.php';
include_once './modulos/index/models/MovieModel.php';
include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
include(RDFAPI_INCLUDE_DIR . "/sparql/SparqlEngine.php");

// Create a SPARQL client

/**
 * Description of SugerirController
 *
 * @author Andres
 */
class SugerirController extends Controller {

    private $nombre = "index";
    private $nombrePeliculasFacebook = array();

    /**
     * Retorna las peliculas preferidas del usuario.
     */
    public function mispreferencias() {
        //verifica si inicio sesion
        if ($this->isLoggedIn()) {
            $peliculas = $this->getPeliculas();
            $programas = $this->getProgramasTelevision();
            $infoSparql = $this->getInfoPeliculasRelacionadas($this->nombrePeliculasFacebook);
            $infoSparql = $this->getInfoPeliculaRovi($infoSparql);
            $pathtoVista = "./modulos/$this->nombre/views/index.php";
            $view = parent::cargarVista($pathtoVista, 'index', array("peliculas" => $peliculas, 'programas' => $programas, 'sugerencias' => $infoSparql));
            parent::renderizarPagina($view->getHTML('sugerir'), $view->getParametros());
        } else {
            header("Location: /index/home/index");
        }
    }

    public function getInfoPeliculaRovi($nombresPeliculas) {
        $roviAPI = new RoviAPI();
        $movieModel = new MovieModel();
        foreach ($nombresPeliculas as $key => $nombre) {
            
            //se reemplaza lso espacios del nombre por +;
            $nombrePeli = str_replace(" ", "+", $nombre);
            $roviRespuesta = $roviAPI->movieInfo($nombrePeli);
            //verificamos si la respuesta a la consulta es correcta.
            if ($roviRespuesta['code'] == 200) {
                //la respuesta fue correcta
                $movieModel->cargarPeliculas($roviRespuesta['video']);
            } else {
                continue;
            }
        }
         return $movieModel->getArrayMovies();
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
            $this->nombrePeliculasFacebook[] = $nombrePeli;
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

    /**
     * 
     */
    public function getInfoPeliculasRelacionadas($peliculas) {

        if ($peliculas != null && !empty($peliculas) && count($peliculas) > 0) {
            $valores = array();
            foreach ($peliculas as $key => $pelicula) {
                // $pelicula =  $pelicula->getData();
                // var_dump($pelicula);
                try {
                    $modelFactory = new ModelFactory();
                    $cliente = $modelFactory->getSparqlClient("http://data.linkedmdb.org/sparql");
                    $query = new ClientQuery();
                    $consulta = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                           PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                           PREFIX movie: <http://data.linkedmdb.org/resource/movie/>
                           PREFIX dc: <http://purl.org/dc/elements/1.1/>

                            SELECT DISTINCT ?actor
                            WHERE {
                                ?titulo rdf:type  movie:film .   
                                ?titulo rdfs:label ?nombre .
  								?titulo movie:actor ?actorresource.
  								?actorresource movie:actor_name ?actor.
  								
                                FILTER regex(?nombre ,'" . $pelicula . "','i')
                            } LIMIT 1";
                    $cliente->setOutputFormat("xml");
                    $query->query($consulta);
                    $resultado = $cliente->query($query);
                    // 
                    $p = xml_parser_create();
                    xml_parse_into_struct($p, $resultado, $vals, $index);
                    xml_parser_free($p);
                    // $htmlTabla = SPARQLEngine::writeQueryResultAsHtmlTable($resultado); 
                    //return $vals;
                    //$nombrePrimerActor = $vals
                    foreach ($vals as $key => $value) {
                        //var_dump($value);

                        if ($value['tag'] == "URI" || $value['tag'] == "LITERAL") {

                            $consulta = "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                           PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
                           PREFIX movie: <http://data.linkedmdb.org/resource/movie/>
                           PREFIX dc: <http://purl.org/dc/elements/1.1/>

                            SELECT DISTINCT ?nombre
                            WHERE {
                                ?titulo rdf:type  movie:film .   
                                ?titulo rdfs:label ?nombre .
  								?titulo movie:actor ?actorresource.
  								?actorresource movie:actor_name '" . $value['value'] . "'.  								
                            } LIMIT 1";
                            $cliente->setOutputFormat("xml");
                            $query->query($consulta);
                            $resultado = $cliente->query($query);
                            // var_dump($resultado);
                            // var_dump($resultado);
                            $p = xml_parser_create();
                            xml_parse_into_struct($p, $resultado, $vals2, $index);
                            xml_parser_free($p);
                            // $htmlTabla = SPARQLEngine::writeQueryResultAsHtmlTable($resultado); 
                            // var_dump($vals);
                            foreach ($vals2 as $key => $k) {
                                if ($k['tag'] == "LITERAL") {
                                    $valores[] = $k['value'];
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    
                }
            }
            return $valores;
        } else {
            //el usuario no tiene peliculas en su red social
            //recomendar peliculas actuales.
        }
    }

    /**
     * 
     * @return type
     */
    public function getProgramasTelevision() {
        $accessToken = $_COOKIE["programate"];
        $json = json_decode(file_get_contents("https://graph.facebook.com/me/television?access_token=" . $accessToken), true);
        return $json['data']; //aun falta obtener los programas de tv como tal.
    }

}

?>
