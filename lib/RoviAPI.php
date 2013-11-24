<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RoviAPI
 *
 * @author Andres
 */
class RoviAPI {

    private $version;

    /**
     * 
     * @param type $version
     */
    public function __construct($version = "v2.1") {
        $this->version = $version;
    }

    /**
     * 
     * @param type $endpoint
     * @param type $entitytype
     * @param type $query
     * @param type $clu
     * @param type $filter
     * @param type $country
     * @param type $language
     * @param type $size
     * @param type $format
     */
    function autoCompleteAPI($endpoint, $entitytype, $query, $clu, $filter, $country = "US", $language = "en", $size = 20, $format = 'json') {
        $sig = md5(RAUTOCOMPLETE . RSSAUTOCOMPLETE . time());
        $baseuri = "http://api.rovicorp.com/search/$this->version/$endpoint/autocomplete?entitytype=$entitytype&query=$query&country=$country&language=en&size=20&sig=$sig&format=json&apikey=" . RAUTOCOMPLETE;
        $json = json_decode(file_get_contents($baseuri));
        return $json;
    }

    /**
     * 
     * @param type $videoquery
     * @param type $serviceId
     * @param type $include
     * @param type $iguide
     * @param type $cosmoid
     * @return type
     */
    function movieInfo($videoquery, $serviceId = null, $include = array(), $iguide = null, $cosmoid = NULL) {
        $sig = md5(RMETADATASEARCH . RSSMETADATASEARCH . time());
        //reemplazar video query por + en los espacios.
        $baseuri = "http://api.rovicorp.com/data/v1.1/video/info?include=images&formatid=127&apikey=" . RMETADATASEARCH . "&sig=$sig&video=$videoquery";
        $respuesta = json_decode(file_get_contents($baseuri), true);
        return $respuesta;
    }

    /**
     * 
     * @param type $videoQuery
     * @return type
     */
    function buscarMovie($videoQuery) {
        $sig = md5(RMETADATASEARCH . RSSMETADATASEARCH . time());
        $url = "http://api.rovicorp.com/search/v2.1/video/search?sig=$sig&entitytype=movie&query=$videoQuery&rep=1&size=5&offset=0&country=CO&language=en&format=json&apikey=" . RMETADATASEARCH;

        $respuesta = json_decode(file_get_contents($url), true);
        return $respuesta;
    }

    /**
     * 
     * @param type $codigopostal
     * @param type $codigoPais
     * @param type $lenguaje
     * @param type $msoid
     * @param type $formato
     */
    function getServices($codigopostal = 0, $codigoPais = "CO", $lenguaje = "es-CO", $msoid = null, $formato = "json") {
        $url = "http://api.rovicorp.com/TVlistings/v9/listings/services/postalcode/$codigopostal/info?locale=$lenguaje&countrycode=$codigoPais&format=$formato&apikey=" . RAPITVLISTINGS;
        $respuesta = json_decode(file_get_contents($url), true);
        return $respuesta;
    }

    static function darCalendario($servicioId, $lenguaje = "es-CO", $duracion = 180, $horaActual = null, $dia) {
        $hoy = date("Y-m-d\T");
        if ($horaActual == null) {
            $horaActual = (date("H") + 5) % 24;
            if ((date("H") + 5) >= 24) {
                $hoy = date("Y-m-d\T",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
            }
        } else {
             if (($horaActual + 5) >= 24) {
                $hoy = date("Y-m-d\T",mktime(0, 0, 0, date("m") , date("d")+1, date("Y")));
            }
            $horaActual = ($horaActual + 5) % 24;
        }

        if ($horaActual < 10) {
            $hoy.="0$horaActual:00:00Z";
        } else {
            $hoy.="$horaActual:00:00Z";
        }
        $url = "http://api.rovicorp.com/TVlistings/v9/listings/gridschedule/$servicioId/info?locale=$lenguaje&duration=$duracion&includechannelimages=false&format=json&startdate=$hoy&apikey=" . RAPITVLISTINGS;
        $respuesta = json_decode(file_get_contents($url), true);
        return $respuesta;
    }
    
    
    public static function darCanalesServicio($idServicio) {       
        $url = "http://api.rovicorp.com/TVlistings/v9/listings/servicedetails/serviceid/$idServicio/info?locale=es-CO&includechannelimages=true&format=json&apikey=" . RAPITVLISTINGS;
        $respuesta = json_decode(file_get_contents($url), true);
        return $respuesta;    
    }

}

?>
