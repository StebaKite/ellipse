<?php

set_include_path('/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'ricercaVociListino.class.php';

$ricercaVociListino = new ricercaVociListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$ricercaVociListino->setIdvocelistino($_GET['idvocelistino']);
		$ricercaVociListino->setIdlistino($_GET['idlistino']);
		$ricercaVociListino->setCodiceListino($_GET['codicelistino']);
		$ricercaVociListino->setDescrizioneListino($_GET['descrizionelistino']);
		$ricercaVociListino->setPrezzo($_GET['prezzo']);
		break;
	case 'POST':
		$ricercaVociListino->setIdvocelistino($_POST['idvocelistino']);
		$ricercaVociListino->setIdlistino($_POST['idlistino']);
		$ricercaVociListino->setCodiceListino($_POST['codicelistino']);
		$ricercaVociListino->setDescrizioneListino($_POST['descrizionelistino']);
		$ricercaVociListino->setPrezzo($_GET['prezzo']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $ricercaVociListino->start();
if ($_GET['modo'] == "go") $ricercaVociListino->go();

?>