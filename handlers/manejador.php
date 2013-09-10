<?php

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
	switch ($errno) {
		case E_USER_ERROR:
			echo "<b>ERROR</b> [$errno] $errstr<br />\n";
			echo "  Error en linea $errline in file $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Abortando...<br />\n";
			exit(1);
			break;

		case E_USER_WARNING:
			echo "<b>Warning</b> [$errno] $errstr<br />\n";
			break;

		case E_USER_NOTICE:
			echo "<b>Notice</b> [$errno] $errstr<br />\n";
			break;

		case E_ERROR:
			echo "Error fatal...<br>";
			break;

		default:
			echo "Error desconocido, valor: [$errno] $errstr<br />\n";
			break;
	}
	return true;
}
?>