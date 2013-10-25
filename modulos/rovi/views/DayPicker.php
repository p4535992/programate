<?

include_once './lib/ViewController.php';

class DayPickerViewController extends ViewController {

    private $parametros;

   

    public function getHTML($vista = 'default') {
        
        $html = '<button type="button" class="btn btn-default"><</button>';
        
        date_default_timezone_set('America/Bogota');
        $dias = array("Dom.", "Lun.", "Mar.", "Mier.", "Jue.", "Vier.", "Sáb");
        $meses = array("En", "Feb", "Mar", "Abr", "Mayo", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
       
        for ($index = 0; $index < 7; $index++) {
            

            $html.='<button type="button" class="btn btn-default">';
               
                if($index==0)
                {
                $html.=  "Hoy, " . (date('d')) ." " . $meses[date('n') - 1] ;    
                }else
                $html.= $dias[(date('w')+$index)%7] . ", " . (date('d')+$index) ." " . $meses[date('n') - 1] ;
                
                
            $html.='</button>';
            
        }
       
        return $html;
    }

    public function getCSS() {
        
    }

}

?>