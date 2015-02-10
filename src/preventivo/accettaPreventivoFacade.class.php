<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/cartellaclinica:/var/www/html/ellipse/src/utility');
require_once 'accettaPreventivo.class.php';

$accettaPreventivo = new accettaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$accettaPreventivo->setIdPaziente($_GET['idPaziente']);
		$accettaPreventivo->setIdListino($_GET['idListino']);
		$accettaPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$accettaPreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$accettaPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$accettaPreventivo->setDataInserimento($_GET['datainserimento']);
		$accettaPreventivo->setStato($_GET['stato']);
		$accettaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$accettaPreventivo->setCognome($_GET['cognome']);
		$accettaPreventivo->setNome($_GET['nome']);
		$accettaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$accettaPreventivo->setIdPaziente($_POST['idPaziente']);
		$accettaPreventivo->setIdListino($_POST['idListino']);
		$accettaPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$accettaPreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$accettaPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$accettaPreventivo->setDataInserimento($_POST['datainserimento']);
		$accettaPreventivo->setStato($_POST['stato']);
		$accettaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$accettaPreventivo->setCognome($_POST['cognome']);
		$accettaPreventivo->setNome($_POST['nome']);
		$accettaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $accettaPreventivo->start();
if ($_GET['modo'] == "go") $accettaPreventivo->go();

?>