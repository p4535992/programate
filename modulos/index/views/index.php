<?php
echo 'contendio del modulo index.';
if (!empty($_POST['json'])) {
    echo $_POST['json'];
} else {
    ?>


    <form method="post" action="." id="formularioface">
        <input type="submit" id="boton" value="Dame Click"/> 
        <input type="hidden" value="index" name="controlador"/>
        <input type="hidden" value="servicios" name="modulo"/>
        <input type="hidden" value="index" name="metodo"/>

    </form>
        <?
}?>