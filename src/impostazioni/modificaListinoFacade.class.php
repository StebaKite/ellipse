<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'modificaListino.class.php';

$modificaListino = new modificaListino();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaListino->setIdlistino($_GET['idlistino']);
		$modificaListino->setCodiceListino($_GET['codicelistino']);
		$modificaListino->setDescrizioneListino($_GET['descrizionelistino']);
		break;
	case 'POST':
		$modificaListino->setIdlistino($_POST['idlistino']);
		$modificaListino->setCodiceListino($_POST['codicelistino']);
		$modificaListino->setDescrizioneListino($_POST['descrizionelistino']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaListino->start();
if ($_GET['modo'] == "go") $modificaListino->go();

?>