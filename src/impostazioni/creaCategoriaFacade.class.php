<?php

set_include_path('/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'creaCategoria.class.php';

$creaCategoria = new creaCategoria();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaCategoria->setCodiceCategoria($_GET['codicecategoria']);
		$creaCategoria->setDescrizioneCategoria($_GET['descrizionecategoria']);
		break;
	case 'POST':
		$creaCategoria->setCodiceCategoria($_POST['codicecategoria']);
		$creaCategoria->setDescrizioneCategoria($_POST['descrizionecategoria']);
				break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaCategoria->start();
if ($_GET['modo'] == "go") $creaCategoria->go();

?>