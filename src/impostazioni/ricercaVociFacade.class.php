<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'ricercaVoci.class.php';

$ricercaVoci = new ricercaVoci();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$ricercaVoci->setIdvoce($_GET['idvoce']);
		$ricercaVoci->setIdcategoria($_GET['idcategoria']);
		$ricercaVoci->setCodiceCategoria($_GET['codicecategoria']);
		$ricercaVoci->setDescrizioneCategoria($_GET['descrizionecategoria']);
		break;
	case 'POST':
		$ricercaVoci->setIdvoce($_POST['idvoce']);
		$ricercaVoci->setIdcategoria($_POST['idcategoria']);
		$ricercaVoci->setCodiceCategoria($_POST['codicecategoria']);
		$ricercaVoci->setDescrizioneCategoria($_POST['descrizionecategoria']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $ricercaVoci->start();
if ($_GET['modo'] == "go") $ricercaVoci->go();

?>