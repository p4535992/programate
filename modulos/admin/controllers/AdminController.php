<?php

include_once './lib/Controller.php';
include_once "./modulos/rovi/controllers/IndexController.php";
/**
 * Clase encargada del manejo de los errores
 */
class AdminController extends Controller {
    /**
     * @var type 
     */
    private $template = '';
    private $nombre = 'errores';

    /**
     * Constructor de la clase.
     */
    public function __construct() {
        $this->nombre = 'errores';
        $this->template = TEMPLATE;
    }
    
    public function guardarProveedores(){
        $roviIndexController = new IndexController();
        $array = $roviIndexController->darProveedoresServicio();        
        foreach ($array as $key => $value) {
            $value['Pais_idPais'] = "1";//id  de colombia
            Aplication::insert("Proveedor_Servicio", $value);             
        }        
    }
    
    public function guardarCanalesProveedor($idProveedor){
       $idProveedor = $_REQUEST['idproveedor'];
       $json =  RoviAPI::darCanalesServicio($idProveedor);
       $json = $json['ServiceDetailsResult']['ChannelLineup']['Channels'];
       //var_dump($json);//se obtienen los canales
       
       foreach ($json as $key => $channel) {
           $canal['idCanal'] = $channel['SourceId'];
           $canal['NombreCompleto'] = $channel['FullName'];
           $canal['Abreviatura'] =  $channel['CallLetters'];
           $canal['SourceId'] =  $channel['SourceId'];
          // $canal['Proveedor_Servicio_idProveedor_Servicio'] = $idProveedor;
           
           Aplication::insert("canal", $canal);     
           Aplication::insert("Proveedor_Servicio_has_Canal", array("Proveedor_Servicio_idProveedor_Servicio"=>$idProveedor ,  "Canal_idCanal"=>$channel['SourceId']));
       }
    }
}