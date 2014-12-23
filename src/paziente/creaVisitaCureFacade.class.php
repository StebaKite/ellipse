<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.cure.class.php';

$creaVisitaCure = new creaVisitaCure();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaVisitaCure->setIdPaziente($_GET['idPaziente']);
		$creaVisitaCure->setIdListino($_GET['idListino']);
		$creaVisitaCure->setCognomeRicerca($_GET['cognRic']);
		break;
	case 'POST':
		$creaVisitaCure->setIdPaziente($_POST['idPaziente']);
		$creaVisitaCure->setIdListino($_POST['idListino']);
		$creaVisitaCure->setCognomeRicerca($_POST['cognRic']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaVisitaCure->start();
if ($_GET['modo'] == "go") $creaVisitaCure->go();

?>
