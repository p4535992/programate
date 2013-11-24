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
        if($_SESSION['autenticado']){
            $username = $_SESSION['username'];   
            $QUERY= "SELECT `canal`.`NombreCompleto` FROM canal, favoritos, usuario WHERE `canal`.`idCanal` = `Favoritos`.`Canal_idCanal`
            and  `Favoritos`.`Usuario_idUsuario` = `Usuario`.`idUsuario` and `Usuario`.`username`= '".$username."'";
            $respuesta = Aplication::selectQuery($QUERY);
            return $respuesta->fetch_assoc();
        }
    }
    
    public function agregarCanalFavorito($idCanal) {
        
    }
    
    public function eliminarCanalFavorito($idCanal){
        
    }
    
    
    
}
