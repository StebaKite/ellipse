<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.class.php';

$creaVisita = new creaVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaVisita->setIdPaziente($_GET['idPaziente']);
		$creaVisita->setIdListino($_GET['idListino']);
		$creaVisita->setCognomeRicerca($_GET['cognRic']);
		break;
	case 'POST':
		$creaVisita->setIdPaziente($_POST['idPaziente']);
		$creaVisita->setIdListino($_POST['idListino']);
		$creaVisita->setCognomeRicerca($_POST['cognRic']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaVisita->start();
if ($_GET['modo'] == "go") $creaVisita->go();

?>
