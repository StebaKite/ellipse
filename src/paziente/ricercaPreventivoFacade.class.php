<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'ricercaPreventivo.class.php';

$ricercaPreventivo = new ricercaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$ricercaPreventivo->setIdPaziente($_GET['idPaziente']);
		$ricercaPreventivo->setIdListino($_GET['idListino']);
		$ricercaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$ricercaPreventivo->setCognome($_GET['cognome']);
		$ricercaPreventivo->setNome($_GET['nome']);
		$ricercaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$ricercaPreventivo->setIdPaziente($_POST['idPaziente']);
		$ricercaPreventivo->setIdListino($_POST['idListino']);
		$ricercaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$ricercaPreventivo->setCognome($_POST['cognome']);
		$ricercaPreventivo->setNome($_POST['nome']);
		$ricercaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET["modo"] == "start") $ricercaPreventivo->start();
if ($_GET["modo"] == "go") $ricercaPreventivo->go();

?>