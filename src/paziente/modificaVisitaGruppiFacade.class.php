<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'modificaVisitaGruppi.class.php';

$modificaVisitaGruppi = new modificaVisitaGruppi();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaVisitaGruppi->setIdPaziente($_GET['idPaziente']);
		$modificaVisitaGruppi->setIdListino($_GET['idListino']);
		$modificaVisitaGruppi->setIdVisita($_GET['idVisita']);
		$modificaVisitaGruppi->setDataInserimento($_GET['datainserimento']);
		$modificaVisitaGruppi->setStato($_GET['stato']);
		$modificaVisitaGruppi->setCognomeRicerca($_GET['cognRic']);
		$modificaVisitaGruppi->setCognome($_GET['cognome']);
		$modificaVisitaGruppi->setNome($_GET['nome']);
		$modificaVisitaGruppi->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaVisitaGruppi->setIdPaziente($_POST['idPaziente']);
		$modificaVisitaGruppi->setIdListino($_POST['idListino']);
		$modificaVisitaGruppi->setIdVisita($_POST['idVisita']);
		$modificaVisitaGruppi->setDataInserimento($_POST['datainserimento']);
		$modificaVisitaGruppi->setStato($_POST['stato']);
		$modificaVisitaGruppi->setCognomeRicerca($_POST['cognRic']);
		$modificaVisitaGruppi->setCognome($_POST['cognome']);
		$modificaVisitaGruppi->setNome($_POST['nome']);
		$modificaVisitaGruppi->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaVisitaGruppi->start();
if ($_GET['modo'] == "go") $modificaVisitaGruppi->go();

?>
