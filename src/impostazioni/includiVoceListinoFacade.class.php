<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'includiVoceListino.class.php';

$includiVoceListino = new includiVoceListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$includiVoceListino->setIdvoce($_GET['idvoce']);
		$includiVoceListino->setIdlistino($_GET['idlistino']);
		$includiVoceListino->setPrezzo($_GET['prezzo']);
		$includiVoceListino->setCodiceListino($_GET['codicelistino']);
		$includiVoceListino->setDescrizioneListino($_GET['descrizionelistino']);
				break;
	case 'POST':
		$includiVoceListino->setIdvoce($_POST['idvoce']);
		$includiVoceListino->setIdlistino($_POST['idlistino']);
		$includiVoceListino->setPrezzo($_POST['prezzo']);
		$includiVoceListino->setCodiceListino($_POST['codicelistino']);
		$includiVoceListino->setDescrizioneListino($_POST['descrizionelistino']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $includiVoceListino->start();
if ($_GET['modo'] == "go") $includiVoceListino->go();

?>