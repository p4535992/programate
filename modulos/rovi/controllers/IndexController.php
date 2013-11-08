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
    public function index(){
        $horario = $this->cargarservicio();
        
        $menudias = $this->getDayPicker();
        $arraydata = $this->darProveedoresServicio();
        $GRID = $this->darGRID($horario);
        $parametros = array("Servicios" =>$arraydata, "horario"=>$horario, "menudias"=>$menudias,"grid"=>$GRID);
        include_once './lib/ViewController.php';
        $pathtoVista = "./modulos/rovi/views/index.php";
        $view = parent::cargarVista($pathtoVista, 'index', $parametros);
        parent::renderizarPagina($view->getHTML(), $view->getParametros());
    }
  /**
   * 
   * @return type
   */          
   private function darProveedoresServicio() {
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
/**
 * 
 */
    private function cargarservicio() {
        if (isset($_POST['servicio'])&&$_POST['servicio'] != NULL) {
            $idServicio = $_POST['servicio'];
        } else {
            $idServicio = "68337";
        }     
        $arreglo = RoviAPI::darCalendario($idServicio);
        //se obtiene la info relevante
        $horario = $arreglo['GridScheduleResult']['GridChannels'];
        return $horario ;
    }
    
    /**
     * 
     * @return type
     */
    private function getDayPicker() {
        $pathtoVista = "./modulos/rovi/views/DayPicker.php";
        $dayPickerView = parent::cargarVista($pathtoVista, 'DayPicker', null);
        return $dayPickerView->getHTML();
    }
    /**
     * 
     * @param type $horario
     * @return type
     */
    private function darGRID($horario) {
        $pathtoVista = "./modulos/rovi/views/Grid.php";
        $dayPickerView = parent::cargarVista($pathtoVista, 'Grid', null);
        $horaActual = 6;
        return $dayPickerView->getHTML($horaActual,$horario);
    }

}

?>
