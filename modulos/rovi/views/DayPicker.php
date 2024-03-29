<?

include_once './lib/ViewController.php';

class DayPickerViewController extends ViewController {

    private $parametros;

    public function getHTML($vista = 'default') {

        $html = '    <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Favoritos
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                             <li> <a href="/rovi/index/index"> Estandar </a> </li>
                            <li> <a href="/rovi/favoritos/index"> Mis Favoritos </a> </li>
                            <li> <a href="/rovi/programate/index"> Mis Programas </a></li>
                            </ul>
                     </div>
                     <div class="btn-group">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Horarios
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                            <li> <a href="/rovi/index/index"> Ahora </a> </li>
                            <li> <a href="/rovi/index/index?horaActual=2"> 2am-5am </a> </li>
                            <li> <a href="/rovi/index/index?horaActual=5"> 5am-8am </a></li>
                            <li> <a href="/rovi/index/index?horaActual=8"> 8am-11am </a></li>
                            <li> <a href="/rovi/index/index?horaActual=11"> 11am-2pm </a></li>
                            <li> <a href="/rovi/index/index?horaActual=14"> 2pm-5pm </a></li>
                            <li> <a href="/rovi/index/index?horaActual=17"> 5pm-8pm </a></li>
                            <li> <a href="/rovi/index/index?horaActual=20"> 8pm-11pm </a></li>
                            <li> <a href="/rovi/index/index?horaActual=23"> 11pm-2am </a></li>
                            </ul>
                     </div>'
                . '<button type="button" class="btn btn-default"><</button>';

        date_default_timezone_set('America/Bogota');
        $dias = array("Dom.", "Lun.", "Mar.", "Mier.", "Jue.", "Vier.", "Sáb");
        $meses = array("En", "Feb", "Mar", "Abr", "Mayo", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

        for ($index = 0; $index < 7; $index++) {
            if ($index == 0) {
                $html.='<button type="button" class="btn btn-default" onclick="window.location.href='."'/rovi/index/index?fecha=".date("Y-m-d\T")."'".'">';
                $html.= "Hoy, " . (date('d')) . " " . $meses[date('n') - 1];
            } else{
                $fecha = date("Y-m-d\T",mktime(0, 0, 0, date("m"), date("d")+$index, date("Y")));
                $html.='<button type="button" class="btn btn-default" onclick="window.location.href='."'/rovi/index/index?fecha=".$fecha."'".'">';
                $html.= $dias[(date('w') + $index) % 7] . ", " . (date('d') + $index) . " " . $meses[date('n') - 1];
            }
            $html.='</button>';
        }
        return $html;
    }

    public function getCSS() {
        
    }

}

?>