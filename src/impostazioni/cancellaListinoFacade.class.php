<?php

set_include_path('/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'cancellaListino.class.php';

$cancellaListino = new cancellaListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaListino->setIdlistino($_GET['idlistino']);
		$cancellaListino->setCodiceListino($_GET['codicelistino']);
		$cancellaListino->setDescrizioneListino($_GET['descrizionelistino']);
		break;
	case 'POST':
		$cancellaListino->setIdlistino($_POST['idlistino']);
		$cancellaListino->setCodiceListino($_POST['codicelistino']);
		$cancellaListino->setDescrizioneListino($_POST['descrizionelistino']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaListino->start();
if ($_GET['modo'] == "go") $cancellaListino->go();

?>