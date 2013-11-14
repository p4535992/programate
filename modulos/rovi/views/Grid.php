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
        $headergrid = '<div><div id="menucabecera" class="row">                
                    <div id="span" class="span2">Canales</div>
                    <div class="prev">  <   </div>';
        for ($index = $inicio; $index < ($inicio + 3); $index++) {
            $headergrid.='<div id="span" class="span2">' . ($index % 24) . ":00</div>";
            $headergrid.='<div id="span" class="span2">' . ($index % 24) . ":30</div>";
        }
        $headergrid.='<div id="span" class="prev"> > </div> </nav> </div>';
        return $headergrid;
    }

    /**
     * 
     * @param type $horarioJson
     */
    private function crearHorarios($horarioJson) {
        $html = '<div class="row">';
        foreach ($horarioJson as $key => $canal) {
            $html.='<div id="calendario" class="span12"><div id="span" class="span2">' . $canal['SourceLongName'] . '</div><ul>';
            $programas = $canal['Airings'];
            foreach ($programas as $key => $value) {
                $html.=$this->getPrograma($value["Duration"], $value['Title']);
            }
            $html.="</ul></div>";
        }
        $html.="</div>";
        return $html;
    }

    private function getPrograma($duracion, $titulo) {
        switch ($duracion) {
            case 30:
                return '<div id="span" class="span2">' . $titulo . '</div>';
            case 60:
                return '<div id="span" class="span2">' . $titulo . '</div>';
            case 90:
                return '<div id="span" class="span2">' . $titulo . '</div>';
            case 120:
                return '<div id="span" class="span2">' . $titulo . '</div>';
        }
    }

   

}
?>

