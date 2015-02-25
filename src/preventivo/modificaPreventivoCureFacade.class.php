<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaPreventivoCure.class.php';

$modificaPreventivoCure = new modificaPreventivoCure();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaPreventivoCure->setIdPaziente($_GET['idPaziente']);
		$modificaPreventivoCure->setIdListino($_GET['idListino']);
		$modificaPreventivoCure->setIdPreventivo($_GET['idPreventivo']);
		$modificaPreventivoCure->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$modificaPreventivoCure->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$modificaPreventivoCure->setDataInserimento($_GET['datainserimento']);
		$modificaPreventivoCure->setStato($_GET['stato']);
		$modificaPreventivoCure->setCognomeRicerca($_GET['cognRic']);
		$modificaPreventivoCure->setCognome($_GET['cognome']);
		$modificaPreventivoCure->setNome($_GET['nome']);
		$modificaPreventivoCure->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaPreventivoCure->setIdPaziente($_POST['idPaziente']);
		$modificaPreventivoCure->setIdListino($_POST['idListino']);
		$modificaPreventivoCure->setIdPreventivo($_POST['idPreventivo']);
		$modificaPreventivoCure->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$modificaPreventivoCure->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$modificaPreventivoCure->setDataInserimento($_POST['datainserimento']);
		$modificaPreventivoCure->setStato($_POST['stato']);
		$modificaPreventivoCure->setCognomeRicerca($_POST['cognRic']);
		$modificaPreventivoCure->setCognome($_POST['cognome']);
		$modificaPreventivoCure->setNome($_POST['nome']);
		$modificaPreventivoCure->setDataNascita($_POST['datanascita']);
		$modificaPreventivoCure->setTotalePreventivoDentiSingoli($_POST['totalesingoli']);
		$modificaPreventivoCure->setTotalePreventivoGruppi($_POST['totalegruppi']);
		$modificaPreventivoCure->setTotalePreventivoCure($_POST['totalecure']);
		$modificaPreventivoCure->setImportoSconto($_POST['importosconto']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaPreventivoCure->start();
if ($_GET['modo'] == "go") $modificaPreventivoCure->go();

?>