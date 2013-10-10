<?php

include_once './lib/Controller.php';

class HomeController extends Controller {

    private $nombre;

    /**
     * 
     * @param type $nombre, nombre del controlador 
     */
    public function __construct($nombre = 'Home') {
        $this->nombre = $nombre;
    }

    function index() {
        //se deben obtener los parametros que me envia facebook.\
        //Si es exitoso se reciben los siguientes parametros.
        
        //se debe confirmar la identidad basados en el codigo
        //y obtener un access token
        
       
        
        
        if (($_REQUEST['access_token'])!= null) {
            $accessToken = $_REQUEST['access_token'];
            $expiracionSegundos = $_REQUEST['expires'];

            //se verifican que los parametros ingresados sean los de la persona que ingreso 
            //para ello obtenemos un token para nuestra aplicacion ;

            $ch = curl_init("/oauth/access_token?client_id={app-id}    &client_secret={app-secret}    &grant_type=client_credentials");
            $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
            // add useragent 
            curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $apptoken = curl_exec($ch);

            //se hace la verificacion correspondiente
            $ch = curl_init("graph.facebook.com/debug_token?input_token=$accessToken&access_token=458867537554408");
            // add useragent 
            curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Execute 
            $json = curl_exec($ch);
            //se debe analizar el Json para verificar la certeza, en caso tal de ser correcto
            //se crea una sesion interna
            $pathtoVista = "./modulos/$this->nombre/views/Facebook.php";
            $view = parent::cargarVista($pathtoVista, 'Facebook', array("apptoken" => $apptoken, "json" => json_decode($json)));
            parent::renderizarPagina($view->getHTML('default'), $view->getParametros());
        } else {
            $pathtoVista = "./modulos/$this->nombre/views/Facebook.php";
            $view = parent::cargarVista($pathtoVista, 'Facebook', null);
            parent::renderizarPagina($view->getHTML('error'), $view->getParametros());
        }
    }
    
    
    function confirmarIdentidad() {
        
    }

}

?>
