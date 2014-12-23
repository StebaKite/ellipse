<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.gruppi.class.php';

$creaVisitaGruppi = new creaVisitaGruppi();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaVisitaGruppi->setIdPaziente($_GET['idPaziente']);
		$creaVisitaGruppi->setIdListino($_GET['idListino']);
		$creaVisitaGruppi->setCognomeRicerca($_GET['cognRic']);
		break;
	case 'POST':
		$creaVisitaGruppi->setIdPaziente($_POST['idPaziente']);
		$creaVisitaGruppi->setIdListino($_POST['idListino']);
		$creaVisitaGruppi->setCognomeRicerca($_POST['cognRic']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaVisitaGruppi->start();
if ($_GET['modo'] == "go") $creaVisitaGruppi->go();

?>
