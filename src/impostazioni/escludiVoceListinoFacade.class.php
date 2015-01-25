<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'escludiVoceListino.class.php';

$escludiVoceListino = new escludiVoceListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$escludiVoceListino->setIdvoce($_GET['idvoce']);
		$escludiVoceListino->setIdlistino($_GET['idlistino']);
		$escludiVoceListino->setCodiceListino($_GET['codicelistino']);
		$escludiVoceListino->setDescrizioneListino($_GET['descrizionelistino']);
		break;
	case 'POST':
		$escludiVoceListino->setIdvoce($_POST['idvoce']);
		$escludiVoceListino->setIdlistino($_POST['idlistino']);
		$escludiVoceListino->setCodiceListino($_POST['codicelistino']);
		$escludiVoceListino->setDescrizioneListino($_POST['descrizionelistino']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $escludiVoceListino->start();
if ($_GET['modo'] == "go") $escludiVoceListino->go();

?>