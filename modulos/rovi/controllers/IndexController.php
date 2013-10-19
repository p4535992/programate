<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './lib/RoviAPI.php';

/**
 * Description of IndexController
 *
 * @author Andres
 */
class IndexController extends Controller {

    /**
     * Obtiene los servicios actuales en colombia.
     * @param type $param
     */
    function darProveedoresServicio() {
        $roviAPI = new RoviAPI();
        $proveedores = $roviAPI->getServices(0, "CO", "es-CO");
        //se obtiene solo la informacion relevante.
        $servicios = $proveedores['ServicesResult']["Services"]['Service'];
        $arraydata = array();
        foreach ($servicios as $key => $value) {
            $arraydata[] = array($value['ServiceId'], $value['Name']);
        }

        return $arraydata;
    }

    function cargarservicio() {
        if ($_POST['servicio'] != NULL) {
            $idServicio = $_POST['servicio'];
        } else {
            $idServicio = "68337";
        }
        $arraydata = $this->darProveedoresServicio();
        $arreglo = RoviAPI::darCalendario($idServicio);
        //se obtiene la info relevante
        $i = $arreglo['GridScheduleResult']['GridChannels'];
        
        $pathtoVista = "./modulos/rovi/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', array("Servicios" => $arraydata, "horario" =>$i));
        parent::renderizarPagina($view->getHTML(), $view->getParametros());
    }

}

?>
