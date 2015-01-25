<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'cancellaCategoria.class.php';

$cancellaCategoria = new cancellaCategoria();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaCategoria->setIdcategoria($_GET['idcategoria']);
		$cancellaCategoria->setCodiceCategoria($_GET['codicecategoria']);
		$cancellaCategoria->setDescrizioneCategoria($_GET['descrizionecategoria']);
		break;
	case 'POST':
		$cancellaCategoria->setIdcategoria($_POST['idcategoria']);
		$cancellaCategoria->setCodiceCategoria($_POST['codicecategoria']);
		$cancellaCategoria->setDescrizioneCategoria($_POST['descrizionecategoria']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaCategoria->start();
if ($_GET['modo'] == "go") $cancellaCategoria->go();

?>