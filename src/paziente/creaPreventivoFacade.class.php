<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'creaPreventivo.class.php';

$creaPreventivo = new creaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaPreventivo->setIdPaziente($_GET['idPaziente']);
		$creaPreventivo->setIdListino($_GET['idListino']);
		$creaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$creaPreventivo->setCognome($_GET['cognome']);
		$creaPreventivo->setNome($_GET['nome']);
		$creaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$creaPreventivo->setIdPaziente($_POST['idPaziente']);
		$creaPreventivo->setIdListino($_POST['idListino']);
		$creaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$creaPreventivo->setCognome($_POST['cognome']);
		$creaPreventivo->setNome($_POST['nome']);
		$creaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaPreventivo->start();
if ($_GET['modo'] == "go") $creaPreventivo->go();

?>