<?php

include_once './lib/Controller.php';

class homeController extends Controller {
    private $nombre;
    public function __construct($nombre) {
        $this->nombre = $nombre;
    }


    public function index($parametros = NULL) {
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        parent::asignar(array('contenido' => $pathtoVista, 'params' => $parametros));
        parent::cargarVista('index', $parametros);
    }

}

?>
