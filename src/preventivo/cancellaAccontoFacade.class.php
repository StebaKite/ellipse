<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'cancellaAcconto.class.php';

$cancellaAcconto = new cancellaAcconto();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaAcconto->setIdPaziente($_GET['idPaziente']);
		$cancellaAcconto->setIdListino($_GET['idListino']);
		$cancellaAcconto->setIdPreventivo($_GET['idPreventivo']);
		$cancellaAcconto->setIdAcconto($_GET['idAcconto']);
		$cancellaAcconto->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$cancellaAcconto->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$cancellaAcconto->setDataInserimento($_GET['datainserimento']);
		$cancellaAcconto->setStato($_GET['stato']);
		$cancellaAcconto->setCognomeRicerca($_GET['cognRic']);
		$cancellaAcconto->setCognome($_GET['cognome']);
		$cancellaAcconto->setNome($_GET['nome']);
		$cancellaAcconto->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$cancellaAcconto->setIdPaziente($_POST['idPaziente']);
		$cancellaAcconto->setIdListino($_POST['idListino']);
		$cancellaAcconto->setIdPreventivo($_POST['idPreventivo']);
		$cancellaAcconto->setIdAcconto($_POST['idAcconto']);
		$cancellaAcconto->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$cancellaAcconto->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$cancellaAcconto->setDataInserimento($_POST['datainserimento']);
		$cancellaAcconto->setStato($_POST['stato']);
		$cancellaAcconto->setCognomeRicerca($_POST['cognRic']);
		$cancellaAcconto->setCognome($_POST['cognome']);
		$cancellaAcconto->setNome($_POST['nome']);
		$cancellaAcconto->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata non prevista!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaAcconto->start();
if ($_GET['modo'] == "go") $cancellaAcconto->go();

?>