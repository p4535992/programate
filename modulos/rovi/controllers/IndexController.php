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
             
        $menudias = $this->getDayPicker();
        $arraydata = $this->darProveedoresServicio();
        $horario = $this->cargarHorarioServicio();  
         if (isset($_GET['horaActual'])&&$_GET['horaActual'] != NULL) {
            $horaActual = $_GET['horaActual'] ;  
        }else{
            $horaActual = date('H');
        }
        $GRID = $this->darGRID($horario, $horaActual);

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
    private function cargarHorarioServicio() {
        if (isset($_POST['servicio'])&&$_POST['servicio'] != NULL) {
            $idServicio = $_POST['servicio'];
        } else {
            $idServicio = "68337";
        }     
        if (isset($_GET['horaActual'])&&$_GET['horaActual'] != NULL) {
            $horaActual = $_GET['horaActual'] ;  
        }else{
            $horaActual = null;
        }
        
        if (isset($_GET['fecha'])&&$_GET['fecha'] != NULL) {
            $dia  = $_GET['fecha'] ;  
        }else{
            $dia = null;
        }
        
        $arreglo = RoviAPI::darCalendario($idServicio, "es_CO", 180, $horaActual, $dia );
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
    private function darGRID($horario, $horaInicial) {
        $pathtoVista = "./modulos/rovi/views/Grid.php";
        $dayPickerView = parent::cargarVista($pathtoVista, 'Grid', null);        
        return $dayPickerView->getHTML($horaInicial,$horario);
    }

}

?>
