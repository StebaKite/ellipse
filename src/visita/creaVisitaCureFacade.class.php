<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.cure.class.php';

$creaVisitaCure = new creaVisitaCure();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaVisitaCure->setIdPaziente($_GET['idPaziente']);
		$creaVisitaCure->setIdListino($_GET['idListino']);
		$creaVisitaCure->setCognomeRicerca($_GET['cognRic']);
		$creaVisitaCure->setCognome($_GET['cognome']);
		$creaVisitaCure->setNome($_GET['nome']);
		$creaVisitaCure->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$creaVisitaCure->setIdPaziente($_POST['idPaziente']);
		$creaVisitaCure->setIdListino($_POST['idListino']);
		$creaVisitaCure->setCognomeRicerca($_POST['cognRic']);
		$creaVisitaCure->setCognome($_POST['cognome']);
		$creaVisitaCure->setNome($_POST['nome']);
		$creaVisitaCure->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaVisitaCure->start();
if ($_GET['modo'] == "go") $creaVisitaCure->go();

?>
