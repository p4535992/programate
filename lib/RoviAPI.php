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
    public function __construct($version="v2.1") {
        $this->version =  $version;
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
    function autoCompleteAPI($endpoint, $entitytype, $query,$clu, $filter,$country="US", $language="en", $size=20, $format='json'){
        $sig = md5(RAUTOCOMPLETE.RSSAUTOCOMPLETE.time());
        $baseuri = "http://api.rovicorp.com/search/$this->version/$endpoint/autocomplete?entitytype=$entitytype&query=$query&country=$country&language=en&size=20&sig=$sig&format=json&apikey=".RAUTOCOMPLETE;
        $json = json_decode(file_get_contents($baseuri));
        return $json;
    }
    
    function videoInfo($videoquery, $serviceId=null, $include=array(), $iguide, $cosmoid ){
        $sig =  md5(RMETADATASEARCH.RSSAUTOCOMPLETE.time());
        //reemplazar video query por + en los espacios.
        $baseuri = "http://api.rovicorp.com/data/v1.1/video/info?apikey=".RMETADATASEARCH."&sig=$sig&video=$videoquery";
        
    }
    
    function buscarMovie($videoQuery){
        $sig =  md5(RMETADATASEARCH.RSSMETADATASEARCH.time());
        $url = "http://api.rovicorp.com/search/v2.1/video/search?sig=$sig&entitytype=movie&query=$videoQuery&rep=1&size=5&offset=0&country=CO&language=en&format=json&apikey=".RMETADATASEARCH;
        $respuesta = json_decode(file_get_contents($url), true);
        return $respuesta;
    }
    
    
}

?>
