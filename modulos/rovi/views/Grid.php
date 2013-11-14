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

            
            <div id="menucabecera" class="row">
                
                    <div class="span2">Canales</div>
                    <div class="prev"> <   </div>
                   ';
        for ($index = $inicio; $index < ($inicio + 3); $index++) {

            $headergrid.='<div  class="span2">' . ($index % 24) . ":00</div>";
            $headergrid.='<div  class="span2">' . ($index % 24) . ":30</div>";
        }

        $headergrid.='<div class="prev">
                                        >
                                      </siv>
            </nav>
        </div>';
        return $headergrid.=$this->getCSS();
    }

    /**
     * 
     * @param type $horarioJson
     */
    private function crearHorarios($horarioJson) {
        $html = '<div class="row"> ';
        foreach ($horarioJson as $key => $canal) {

            $html.= '<div id="calendario" class="row">';
            $html.='<div class="span2">'.$canal['SourceLongName'].
                    '
                    </div>                    
                    <div class="span2">6:00</div>
                    <div class="span2">6:30</div>
                    <div class="span2">7:00</div>                    
                    <div class="span2">7:30</div>
                    <div class="span2">8:00</div>
                    <div class="span2">8:30</div>
                    </div>';
            $programas = $canal['Airings'];
        }
        $html.="</div>";
        return $html;
    }

    public function getCSS() {
        return "
            <style>
           #menucabecera{
           margin-left:0px;
           }
            #calendario{
            margin:20px;
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
                padding:10px;
            }

            .hora{
                display: inline-block;
                width: 14%;
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

