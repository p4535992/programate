<?php

include_once ('./lib/Controller.php');
require_once("./lib/facebook.php");
require_once("./conf/config.php");

class indexController extends Controller {
private $nombre = 'index';

    public function index($parametros=null) {

        $config = array();
        $config['appId'] = APPID;
        $config['secret'] = APPSECRET;
        $facebook = new Facebook($config);

        if (isset($_SESSION['access_token'])) {

            $facebook->setAccessToken($_SESSION['access_token']);
        }

        $user_id = $facebook->getUser();

        if ($user_id) {

            $opcion = "";
            $query = "";
            $jsonDecodificado = "";
            if (isset($_REQUEST['opcion'])) {

                $opcion = $_REQUEST['opcion'];
            }
            if (isset($_REQUEST['query'])) {

                $query = $_REQUEST['query'];
            }
            if ($opcion != "") {

                $jsonDecodificado = json_encode($facebook->api('/me/' . $opcion));
            } else
            if ($query != "") {
                $jsonDecodificado = json_encode($facebook->api(array('method' => 'fql.query', 'query' => $query)));
            } else {
                $jsonDecodificado = json_encode($facebook->api('/me'));
            }
            
         $parametros = array('json'=>$jsonDecodificado);
        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        parent::asignar(array('contenido' => $pathtoVista, 'params' => $parametros));
        parent::cargarVista('index', $parametros);
    
            
        } else {
            $this->consultarInformacionUsuario($facebook);
        }
    }

    public function consultarInformacionUsuario($facebook) {
        $params = array(
            'scope' => 'email, user_likes, user_photos, user_videos',
            'redirect_uri' => URL_REDIRECT
                )
        ;

        $loginUrl = $facebook->getLoginUrl($params);
        header('Location: ' . $loginUrl);
    }

    public function recibirInformacion() {
        session_start();
        if (isset($_GET['code'])) {
            include_once("constants.php");
            $tokenDetails = $this->getAccessTokenDetails(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET_ID, URL_REDIRECT, $_GET['code']);
            $token = $tokenDetails['access_token'];
            $_SESSION['access_token'] = $token;

            $this->index();
            // header('Location: ' . URL_PAGE);
        }
    }

    function getAccessTokenDetails($app_id, $app_secret, $redirect_url, $code) {

        $token_url = "https://graph.facebook.com/oauth/access_token?"
                . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirect_url)
                . "&client_secret=" . $app_secret . "&code=" . $code;

        $response = file_get_contents($token_url);

        // curl_init()


        $params = null;

        parse_str($response, $params);

        return $params;
    }

}

?>