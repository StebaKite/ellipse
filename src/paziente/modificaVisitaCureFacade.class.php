<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'modificaVisitaCure.class.php';

$modificaVisitaCure = new modificaVisitaCure();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaVisitaCure->setIdPaziente($_GET['idPaziente']);
		$modificaVisitaCure->setIdListino($_GET['idListino']);
		$modificaVisitaCure->setIdVisita($_GET['idVisita']);
		$modificaVisitaCure->setDataInserimento($_GET['datainserimento']);
		$modificaVisitaCure->setStato($_GET['stato']);
		$modificaVisitaCure->setCognomeRicerca($_GET['cognRic']);
		$modificaVisitaCure->setCognome($_GET['cognome']);
		$modificaVisitaCure->setNome($_GET['nome']);
		$modificaVisitaCure->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaVisitaCure->setIdPaziente($_POST['idPaziente']);
		$modificaVisitaCure->setIdListino($_POST['idListino']);
		$modificaVisitaCure->setIdVisita($_POST['idVisita']);
		$modificaVisitaCure->setDataInserimento($_POST['datainserimento']);
		$modificaVisitaCure->setStato($_POST['stato']);
		$modificaVisitaCure->setCognomeRicerca($_POST['cognRic']);
		$modificaVisitaCure->setCognome($_POST['cognome']);
		$modificaVisitaCure->setNome($_POST['nome']);
		$modificaVisitaCure->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaVisitaCure->start();
if ($_GET['modo'] == "go") $modificaVisitaCure->go();

?>
