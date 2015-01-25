<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'modificaVoceListino.class.php';

$modificaVoceListino = new modificaVoceListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaVoceListino->setIdvocelistino($_GET['idvocelistino']);
		$modificaVoceListino->setIdlistino($_GET['idlistino']);
		$modificaVoceListino->setCodiceListino($_GET['codicelistino']);
		$modificaVoceListino->setDescrizioneListino($_GET['descrizionelistino']);
		$modificaVoceListino->setCodiceVoce($_GET['codicevoce']);
		$modificaVoceListino->setDescrizioneVoce($_GET['descrizionevoce']);
		$modificaVoceListino->setPrezzo($_GET['prezzo']);
		break;
	case 'POST':
		$modificaVoceListino->setIdvocelistino($_POST['idvocelistino']);
		$modificaVoceListino->setIdlistino($_POST['idlistino']);
		$modificaVoceListino->setCodiceListino($_POST['codicelistino']);
		$modificaVoceListino->setDescrizioneListino($_POST['descrizionelistino']);
		$modificaVoceListino->setCodiceVoce($_POST['codicevoce']);
		$modificaVoceListino->setDescrizioneVoce($_POST['descrizionevoce']);
		$modificaVoceListino->setPrezzo($_POST['prezzo']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaVoceListino->start();
if ($_GET['modo'] == "go") $modificaVoceListino->go();

?>