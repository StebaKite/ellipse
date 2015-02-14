<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/cartellaclinica:/var/www/html/ellipse/src/utility');
require_once 'rinunciaPreventivo.class.php';

$rinunciaPreventivo = new rinunciaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$rinunciaPreventivo->setIdPaziente($_GET['idPaziente']);
		$rinunciaPreventivo->setIdListino($_GET['idListino']);
		$rinunciaPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$rinunciaPreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$rinunciaPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$rinunciaPreventivo->setDataInserimento($_GET['datainserimento']);
		$rinunciaPreventivo->setStato($_GET['stato']);
		$rinunciaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$rinunciaPreventivo->setCognome($_GET['cognome']);
		$rinunciaPreventivo->setNome($_GET['nome']);
		$rinunciaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$rinunciaPreventivo->setIdPaziente($_POST['idPaziente']);
		$rinunciaPreventivo->setIdListino($_POST['idListino']);
		$rinunciaPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$rinunciaPreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$rinunciaPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$rinunciaPreventivo->setDataInserimento($_POST['datainserimento']);
		$rinunciaPreventivo->setStato($_POST['stato']);
		$rinunciaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$rinunciaPreventivo->setCognome($_POST['cognome']);
		$rinunciaPreventivo->setNome($_POST['nome']);
		$rinunciaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $rinunciaPreventivo->start();
if ($_GET['modo'] == "go") $rinunciaPreventivo->go();

?>