<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'creaPreventivo.cure.class.php';

$creaPreventivoCure = new creaPreventivoCure();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaPreventivoCure->setIdPaziente($_GET['idPaziente']);
		$creaPreventivoCure->setIdListino($_GET['idListino']);
		$creaPreventivoCure->setCognomeRicerca($_GET['cognRic']);
		$creaPreventivoCure->setCognome($_GET['cognome']);
		$creaPreventivoCure->setNome($_GET['nome']);
		$creaPreventivoCure->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$creaPreventivoCure->setIdPaziente($_POST['idPaziente']);
		$creaPreventivoCure->setIdListino($_POST['idListino']);
		$creaPreventivoCure->setCognomeRicerca($_POST['cognRic']);
		$creaPreventivoCure->setCognome($_POST['cognome']);
		$creaPreventivoCure->setNome($_POST['nome']);
		$creaPreventivoCure->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaPreventivoCure->start();
if ($_GET['modo'] == "go") $creaPreventivoCure->go();

?>