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

    /**
     * 
     */
    function index() {
        //se deben obtener los parametros que me envia facebook.\
        //Si es exitoso se reciben los siguientes parametros.
        //se debe confirmar la identidad basados en el codigo
        //y obtener un access token

        if (($_REQUEST['access_token']) != null) {
            $accessToken = $_REQUEST['access_token'];
            $expiracionSegundos = $_REQUEST['expires'];

            //se verifican que los parametros ingresados sean los de la persona que ingreso 
            //para ello obtenemos un token para nuestra aplicacion ;
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

    /**
     * 
     */
    function confirmarIdentidad() {
        if (!empty($_GET['code'])) {
            $redirectURL = "http://anfho93.sytes.net/facebook/home/confirmarIdentidad";
            $url = "Location: https://graph.facebook.com/oauth/access_token?client_id=" . APPID . "&redirect_uri=" . $redirectURL . "&client_secret=" . APPSECRET . "&code=" . $_GET['code'];
            $url = "https://graph.facebook.com/oauth/access_token?client_id=" . APPID . "&redirect_uri=" . $redirectURL . "&client_secret=" . APPSECRET . "&code=" . $_GET['code'];

            $accessToken = file_get_contents($url);

            @list($aT, $expiracion ) = explode("&", $accessToken, 2);
            list($i, $valorToken ) = explode("=", $aT);
            list($j, $expiracion ) = explode("=", $expiracion);

            //Luego de tener el token y su tiempo de expiracion es necesario inspeccionarlos
            //para ello es necesario obtener un APP token de la aplicacion
            $url = "https://graph.facebook.com/oauth/access_token?client_id=" . APPID . "&client_secret=" . APPSECRET . "&grant_type=client_credentials";
            $appToken = file_get_contents($url);
            list($k, $appToken ) = explode("=", $appToken);

            // $jsonarray = $this->inspeccionarToken($accessToken, $expiracion, $appToken);
            if (true) {
                //el token es valido.
                $this->login($appToken, $accessToken, $expiracion);
               
            } else {
                $pathtoVista = "./modulos/$this->nombre/views/Facebook.php";
                $view = parent::cargarVista($pathtoVista, 'Facebook', array("json" => $jsonarray));
                parent::renderizarPagina($view->getHTML('error'), $view->getParametros());
            }
        } else {
            //nego la peticion
            if ($_GET['error_reason'] != null) {
                /* error_reason=user_denied
                  &error=access_denied
                  &error_description=The+user+denied+your+request. */
                $app = Aplication::getInstance();
                $msg = $_GET["error_reason"] . " " . $_GET["error"] . " " . $_GET['error_description'];
                $app->error('000', $msg, "Cancelaste el facebook Login");
            }
        }
    }

    /**
     * 
     * @param type $appToken
     * @param type $accessToken
     * @param type $expiracion
     */
    function login($appToken, $accessToken, $expiracion) {


        //agregamos una variables de sesion.
        $userId = null;        
        setcookie("programate", $accessToken, time() + $expiracion, "/", "anfho93.sytes.net");
        setcookie('expiracion', $expiracion, time() + $expiracion,  "/", "anfho93.sytes.net");
        header('location: /');
    }

    /**
     * 
     * @param type $accessToken
     * @param type $expiracion
     * @param type $apptoken
     * @return type
     */
    function inspeccionarToken($accessToken, $expiracion, $apptoken) {

        $url = "graph.facebook.com/debug_token?input_token=$accessToken&access_token=$apptoken";
        $JSON = $this->ejecutarCURL($url);
        $JSON = json_decode($JSON, true);
        return $JSON;
    }

    /**
     * 
     */
    function logOut() {
        
        if(!empty( $_COOKIE['expiracion']) && !empty( $_COOKIE['programate'])){
            setcookie ("programate", "", time() - $_COOKIE['expiracion'], "/", "anfho93.sytes.net");
            header('location: /');
        }
        
    }

}

?>
