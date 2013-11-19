<?php

include_once './lib/ViewController.php';

class GridViewController extends ViewController {

    private $tiempoActual;

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
        $headergrid = '<div>';
        $headergrid.= '<thead>'
                            .'<tr>'
                                .'<th>';

        $headergrid.= '<div id="menucabecera" class="row-fluid">                
                    <div id="span" class="span1">Canales</div> ';

        for ($index = $inicio; $index < ($inicio + 3); $index++) {

            $headergrid.='<div id="span" class="span2">' . ($index % 24) . ":00</div>";
            $headergrid.='<div id="span" class="span2">' . ($index % 24) . ":30</div>";
        }
        $headergrid.=' </nav> </div>'

                                .'</th>'
                            . '</tr>'
                        . '</thead>';
        return $headergrid;
    }

    /**
     * 
     * @param type $horarioJson
     */
    private function crearHorarios($horarioJson) {
        $html = '<tbody>'
                . '<tr>'
                . '<td>';

        $html.= '<div class="row-fluid" style="margin-left:0px;">';
        foreach ($horarioJson as $key => $canal) {
            $html.='<div class="row-fluid" style="margin-left:0px;">';
            $html.='<div id="span" class="span1">' . $canal['SourceLongName'] . '</div>';
            $programas = $canal['Airings'];
            foreach ($programas as $key => $value) {
                if ($this->tiempoActual >= 180) {
                    break;
                }
                $html.=$this->getPrograma($value["Duration"], $value['Title']);
            }
            $this->tiempoActual = 0;
            $html.='</div>';
        }
        $html.="</div>";
        $html.='</td>'
                . '</tr>'
                . '</tbody>';
        return $html;
    }

    private function getPrograma($duracion, $titulo) {
        if ($duracion > 180) {
            $duracion = 180;
        }
        if (($this->tiempoActual + $duracion ) > 180) {
            $duracion+=$this->tiempoActual;
            $duracion-=180;
        }
        $this->tiempoActual+=$duracion;
        $tamanoNormal = 14.8936;
        $tamanoNuevoDiv = ($duracion * $tamanoNormal) / 30;
        return '<div id="span" class="span1"' . 'style="width:' . $tamanoNuevoDiv . '%;">' . $titulo . '</div>';
    }

}
?>

