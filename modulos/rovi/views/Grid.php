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

class GridViewController extends ViewController {

    /**
     * 
     * @param type $inicio, Horario de inicio del Horario
     */
    public function getHTML($inicio = 6, $horariojson) {
        //se crea el header.
        $horariosServicio = $this->crearHorarios($horariojson);
        return ($this->getHeaderGrid($inicio) . $horariosServicio);
    }

    private function getHeaderGrid($inicio) {
        $headergrid = '<div>

            
            <nav class="menucabecera">
                <ul >
                    <li class="canales"><div>Canales</div></li>
                    <li class="prev"><                 </li>
                   ';
        for ($index = $inicio; $index < ($inicio + 3); $index++) {

            $headergrid.='<li  class="hora">' . ($index % 24) . ":00</li>";
            $headergrid.='<li  class="hora">' . ($index % 24) . ":30</li>";
        }

        $headergrid.='<li class="prev">
                                        >
                                      </li>
                                      </ul>
            </nav>
        </div>';
        return $headergrid.=$this->getCSS();
    }

    /**
     * 
     * @param type $horarioJson
     */
    private function crearHorarios($horarioJson) {
        $html = '<div> <ul class="channels">';
        foreach ($horarioJson as $key => $canal) {


            $html.='<li class="canales">'.$canal['SourceLongName'].'
                    
                    </li>                    
                    <li class="hora">6:00</li>
                    <li class="hora">6:30</li>
                    <li class="hora">7:00</li>                    
                    <li class="hora">7:30</li>
                    <li class="hora">8:00</li>
                    <li class="hora">8:30</li>
                    ';
        }
        $html.="</ul></div>";
        return $html;
    }

    public function getCSS() {
        return "
            <style>
           .menucabecera ul{
                padding: 0;
                background: rgba(0,0,0,.5);
                font-size: 0;
            }
            
            .channels{
                padding: 0;
                background: rgba(0,0,0,.5);
                font-size: 0;
            }
             .canales  {
                display: inline-block;               
                font-size: 14.4px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                text-align: center;
                 width: 8%;
            }

            .hora{
                display: inline-block;
                width: 14.28%;
                font-size: 14.4px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                text-align: center;
            }
            
            
                        
            .prev {
                display: inline-block;
                font-size: 14.4px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                text-align: center;
                width: 3%;
            }
            
 .menucabecera ul li:hover{
                background:rgba(0,0,0,.3);
            }
            </style>";
    }

}
?>

