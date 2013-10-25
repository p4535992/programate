<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grid
 *
 * @author Andres
 */include_once './lib/ViewController.php';
class GridViewController extends ViewController{
    
    /**
     * 
     * @param type $inicio, Horario de inicio del Horario
     */
    public function getHTML($inicio=6) {
        //se crea el header.
        $headergrid = '<div class="grid_header" style=" position: relative;">

            
            <nav>
                <ul>
                    <li>
                        <div class="prev">

                            Canales

                        </div>
                    </li>
                    <li>
                        <div class="prev">

                            Prev

                        </div>
                    </li>
                    <li>6:00</li>
                    <li>7:00</li>
                    <li>8:00</li>                    
                    <li>9:00</li>
                    <li><div class="next">

                            Next

                        </div></li>
                </ul>
            </nav>

            

        </div>';
        return $headergrid;
        
    }
}

?>
