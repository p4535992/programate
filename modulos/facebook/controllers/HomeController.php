<?php

include_once './lib/Controller.php';

class HomeController extends Controller {

    /**
     *
     * @var type Nombre del controlador.
     */
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
        
    }

    /**
     * Metodo inicial del Modulo de facebook, donde se obtiene el codigo generado por facebook. Luego de que el cliente acepte 
     *
     * luego envia una peticion para obtener un accessToken 
     */
    function confirmarIdentidad() {
        if (!empty($_GET['code'])) {
            $redirectURL = "http://programate.com/facebook/home/confirmarIdentidad";
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

            $arrayInspeccion = $this->inspeccionarToken(trim($valorToken, '"'), trim($expiracion, '"'), trim($appToken, '"'));
            $validez = $arrayInspeccion["data"]["is_valid"];
            if ($validez) {
                //el token es valido.
                $this->login(trim($appToken,'"'), trim($valorToken, '"'), $expiracion);
                
            } else {
                
                $pathtoVista = "./modulos/$this->nombre/views/Facebook.php";
                $view = parent::cargarVista($pathtoVista, 'Facebook', array("json" => $arrayInspeccion));
                parent::renderizarPagina($view->getHTML('error'), $view->getParametros());
            }
        } else {
            //nego la peticion
            if ($_GET['error_reason'] != null) {

                //se muestra el error enviado por facebook.
                $app = Aplication::getInstance();
                $msg = $_GET["error_reason"] . " " . $_GET["error"] . " " . $_GET['error_description'];
                $app->error('000', $msg, "Cancelaste el facebook Login");
            }
        }
    }

    /**
     * 
     * @param type $appToken, token generado para la aplicacion por facebook
     * @param type $accessToken, token generado para este usuario especifico
     * @param type $expiracion, expiracion del token
     */
    function login($appToken, $accessToken, $expiracion) {


        $_SESSION['autenticado'] = true;
        $json = $this->getUser($accessToken);
        //se cambian las cookies para crear la sesion.
        setcookie("programate", $accessToken, time() + $expiracion, "/", "anfho93.sytes.net");
        setcookie('expiracion', $expiracion, time() + $expiracion, "/", "anfho93.sytes.net");
        
        //$pathtoVista = "./modulos/index/views/index.php";
        //$view = parent::cargarVista($pathtoVista, 'index', array("json" => $json, "access" => $accessToken));
        //parent::renderizarPagina($view->getHTML('default'), $view->getParametros());
        header("Location: http://anfho93.sytes.net");
    }

    /**
     * Verifica si el token enviado es correcto y valido
     * @param type $accessToken
     * @param type $expiracion
     * @param type $apptoken
     * @return type
     */
    function inspeccionarToken($accessToken, $expiracion, $apptoken) {

        $url = "https://graph.facebook.com/debug_token?input_token=$accessToken&access_token=$apptoken";
        $JSON = file_get_contents($url);
        $JSON = json_decode($JSON, true);
        return $JSON;
    }

    /**
     * Obtiene un usuario de facebook en este caso el usuario que se logeo.
     * @param type $accessToken
     * @return type
     */
    function getUser($accessToken) {
        $url = "https://graph.facebook.com/me?access_token=" . $accessToken;
        $JSON = file_get_contents($url);

        return json_decode($JSON, true);
    }

    /**
     * Funcion encargada de eliminar las cookies de sesion.
     */
    function logOut() {

        if (!empty($_COOKIE['expiracion']) && !empty($_COOKIE['programate'])) {
            setcookie("programate", "", time() - $_COOKIE['expiracion'], "/", "anfho93.sytes.net");
            header('location: /');
        }
    }
    
    

}

?>
