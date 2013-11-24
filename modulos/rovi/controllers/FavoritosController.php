<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FavoritosController
 *
 * @author Andres
 */
class FavoritosController extends Controller  {
    
    public function index() {        
        if(empty($_COOKIE['programate']) && isset($_SESSION['autenticado']) && $_SESSION['autenticado'])
        {    $pathtoVista = "./modulos/rovi/views/login.php";
             $view = parent::cargarVista($pathtoVista, 'login', null);
             parent::renderizarPagina($view->getHTML(), $view->getParametros());
        }else{                
             $pathtoVista = "./modulos/rovi/views/Favoritos.php";
             $view = parent::cargarVista($pathtoVista, 'Favoritos', array("canales"=>$this->getCanalesFavoritos()));
             parent::renderizarPagina($view->getHTML(), $view->getParametros());            
        }
    }
    /**
     * Obtiene los canales favoritos del usuario actual
     */
    private function getCanalesFavoritos(){
        if (parent::isLoggedIn()) {
            $username = $_SESSION['username'];
                        $QUERY = "SELECT `canal`.`NombreCompleto` FROM canal, favoritos, usuario WHERE `canal`.`idCanal` = `Favoritos`.`Canal_idCanal`
            and  `Favoritos`.`Usuario_idUsuario` = `Usuario`.`idUsuario` and `Usuario`.`username`= '" . $username . "'";
            $respuesta = Aplication::selectQuery($QUERY);
            return $respuesta->fetch_assoc();
        } else {
            return NULL;
        }
    }
    
    public function agregarCanalFavorito($idCanal=null) {
        //se verfica que esta autenticaso
        $idCanal = $_REQUEST["idcanal"];
        if(parent::isLoggedIn()){
              $username = $_SESSION['username'];
              
              $id = parent::getUserId($username);
              var_dump($username);
              Aplication::insert("Favoritos", array("Usuario_idUsuario"=>$id, "Canal_idCanal"=>$idCanal));
        }else{
            //renderizar la pagina correspondiente
        }
    }
    
    public function eliminarCanalFavorito($idCanal=null){
        $idCanal = $_REQUEST["idcanal"];
        if(parent::isLoggedIn()){
              $username = $_SESSION['username'];              
              $id = parent::getUserId($username);
             // var_dump($username);
              Aplication::delete("Favoritos", "Usuario_idUsuario = $id and Canal_idCanal = $idCanal");
        }else{
            //renderizar la pagina correspondiente
        }
    }
    
    
    
}
