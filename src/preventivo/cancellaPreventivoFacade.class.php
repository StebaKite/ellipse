<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'cancellaPreventivo.class.php';

$cancellaPreventivo = new cancellaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaPreventivo->setIdPaziente($_GET['idPaziente']);
		$cancellaPreventivo->setIdListino($_GET['idListino']);
		$cancellaPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$cancellaPreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$cancellaPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$cancellaPreventivo->setDataInserimento($_GET['datainserimento']);
		$cancellaPreventivo->setStato($_GET['stato']);
		$cancellaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$cancellaPreventivo->setCognome($_GET['cognome']);
		$cancellaPreventivo->setNome($_GET['nome']);
		$cancellaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$cancellaPreventivo->setIdPaziente($_POST['idPaziente']);
		$cancellaPreventivo->setIdListino($_POST['idListino']);
		$cancellaPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$cancellaPreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$cancellaPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$cancellaPreventivo->setDataInserimento($_POST['datainserimento']);
		$cancellaPreventivo->setStato($_POST['stato']);
		$cancellaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$cancellaPreventivo->setCognome($_POST['cognome']);
		$cancellaPreventivo->setNome($_POST['nome']);
		$cancellaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaPreventivo->start();
if ($_GET['modo'] == "go") $cancellaPreventivo->go();

?>