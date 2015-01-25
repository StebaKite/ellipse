<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'creaListino.class.php';

$creaListino = new creaListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaListino->setIdlistino($_GET['idlistino']);
		$creaListino->setCodiceListino($_GET['codicelistino']);
		$creaListino->setDescrizioneListino($_GET['descrizionelistino']);
		break;
	case 'POST':
		$creaListino->setIdlistino($_POST['idlistino']);
		$creaListino->setCodiceListino($_POST['codicelistino']);
		$creaListino->setDescrizioneListino($_POST['descrizionelistino']);
				break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaListino->start();
if ($_GET['modo'] == "go") $creaListino->go();

?>