<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaPreventivoGruppi.class.php';

$modificaPreventivoGruppi = new modificaPreventivoGruppi();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaPreventivoGruppi->setIdPaziente($_GET['idPaziente']);
		$modificaPreventivoGruppi->setIdListino($_GET['idListino']);
		$modificaPreventivoGruppi->setIdPreventivo($_GET['idPreventivo']);
		$modificaPreventivoGruppi->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$modificaPreventivoGruppi->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$modificaPreventivoGruppi->setDataInserimento($_GET['datainserimento']);
		$modificaPreventivoGruppi->setStato($_GET['stato']);
		$modificaPreventivoGruppi->setCognomeRicerca($_GET['cognRic']);
		$modificaPreventivoGruppi->setCognome($_GET['cognome']);
		$modificaPreventivoGruppi->setNome($_GET['nome']);
		$modificaPreventivoGruppi->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaPreventivoGruppi->setIdPaziente($_POST['idPaziente']);
		$modificaPreventivoGruppi->setIdListino($_POST['idListino']);
		$modificaPreventivoGruppi->setIdPreventivo($_POST['idPreventivo']);
		$modificaPreventivoGruppi->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$modificaPreventivoGruppi->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$modificaPreventivoGruppi->setDataInserimento($_POST['datainserimento']);
		$modificaPreventivoGruppi->setStato($_POST['stato']);
		$modificaPreventivoGruppi->setCognomeRicerca($_POST['cognRic']);
		$modificaPreventivoGruppi->setCognome($_POST['cognome']);
		$modificaPreventivoGruppi->setNome($_POST['nome']);
		$modificaPreventivoGruppi->setDataNascita($_POST['datanascita']);
		$modificaPreventivoGruppi->setTotalePreventivoDentiSingoli($_POST['totalesingoli']);
		$modificaPreventivoGruppi->setTotalePreventivoGruppi($_POST['totalegruppi']);
		$modificaPreventivoGruppi->setTotalePreventivoCure($_POST['totalecure']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaPreventivoGruppi->start();
if ($_GET['modo'] == "go") $modificaPreventivoGruppi->go();

?>