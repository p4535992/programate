<?php

include_once './lib/ViewController.php';

/**
 * Description of FacebookViewController
 *
 * @author Andres
 */
class FacebookViewController extends ViewController{
   /**
    * 
    * @param type $vista
    * @return type
    */
    public function getHTML($vista) {
       return  parent::getHTML("facebook", $vista);
    }
    
}

?>
