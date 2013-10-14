<?php
 require_once "lib/phpSesame/phpSesame.php";
 
 
 class SesameStore{
 
 const REPOSITORY='24';
 
 
 
 public function query($query)
 {
  $sesame = array ('url' => 'http://localhost:8080/openrdf-sesame', 'repository' => self::REPOSITORY);
  $store = new phpSesame($sesame['url'], $sesame['repository']);
 
  $resultFormat = phpSesame::SPARQL_XML;
  $lang = "sparql";
  $infer = true;
  //echo $query;
  
  $result = $store->query($query, $resultFormat, $lang,'true');// $infer);

  
	return $result;
  }
 
 public function loadFile($rdfPath, $rdfName)
 {
    //print_r("in loadFile");
	$sesame = array ('url' => 'http://localhost:8080/openrdf-sesame', 'repository' => self::REPOSITORY);

	$store = new phpSesame($sesame['url'], $sesame['repository']);

	$context = "<file://". $rdfName .">"; // Optional - defaults to entire repository though.
	$inputFormat = phpSesame::TURTLE; // Optional - defaults to RDFXML
    //print_r("in loadFile: ");
	$store->appendFile($rdfPath, $context, $inputFormat);
 
 }
 
 

 
 }