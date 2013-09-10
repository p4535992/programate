<?php

include_once ('./lib/Controller.php');
require_once("./lib/facebook.php");
require_once("./conf/config.php");

class indexController extends Controller {

    private $nombre = 'index';

    public function index($parametros = null) {

        $config = array();
        $config['appId'] = APPID;
        $config['secret'] = APPSECRET;
        $facebook = new Facebook($config);




        $pathtoVista = "./modulos/$this->nombre/views/index.php";
        parent::asignar(array('contenido' => $pathtoVista, 'params' => $parametros));
        parent::cargarVista('index', $parametros);



        $this->consultarInformacionUsuario($facebook);
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
            $tokenDetails = $this->getAccessTokenDetails(APPID, APPSECRET, URL_REDIRECT, $_GET['code']);
            $token = $tokenDetails['access_token'];
            $_SESSION['access_token'] = $token;

            $config = array();
            $config['appId'] = APPID;
            $config['secret'] = APPSECRET;
            $facebook = new Facebook($config);

            if (isset($_SESSION['access_token'])) {
               // echo "entre";
                $facebook->setAccessToken($_SESSION['access_token']);
            }

          //  $user_id = $facebook->getUser();



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

            
            $pathtoVista = "./modulos/$this->nombre/views/index.php";
            parent::asignar(array('contenido' => $pathtoVista, 'json' => $jsonDecodificado));
            parent::cargarVista('index', $parametros);
            // header('Location: ' . URL_PAGE);
        }
    }

    function getAccessTokenDetails($app_id, $app_secret, $redirect_url, $code) {

        $token_url = "https://graph.facebook.com/oauth/access_token?"
                . "client_id=" . $app_id . "&redirect_uri=" . urlencode($redirect_url)
                . "&client_secret=" . $app_secret . "&code=" . $code;

       // $response = file_get_contents($token_url);
        
        
        $c = curl_init($token_url);      
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';


// agregamos el agente de usuario
        curl_setopt($c, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
// Ejecuta la peticion,
        $resultado = curl_exec($c);

// verifica si algun error ocurrio
        if (!curl_errno($c)) {
//$info = curl_getinfo($ch);
//echo '<hr>Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url']; 
        }
// Cierra el manejador de peticiones 
        curl_close($c);
        // curl_init()


        $params = null;

        parse_str($resultado, $params);

        return $params;
    }

}

?>