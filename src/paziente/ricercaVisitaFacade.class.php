<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'ricercaVisita.class.php';

$ricercaVisita = new ricercaVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$ricercaVisita->setIdPaziente($_GET['idPaziente']);
		$ricercaVisita->setIdListino($_GET['idListino']);
		$ricercaVisita->setCognomeRicerca($_GET['cognRic']);
		break;
	case 'POST':
		$ricercaVisita->setIdPaziente($_POST['idPaziente']);
		$ricercaVisita->setIdListino($_POST['idListino']);
		$ricercaVisita->setCognomeRicerca($_POST['cognRic']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET["modo"] == "start") $ricercaVisita->start();
if ($_GET["modo"] == "go") $ricercaVisita->go();

?>
