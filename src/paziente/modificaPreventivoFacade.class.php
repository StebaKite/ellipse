<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaPreventivo.class.php';

$modificaPreventivo = new modificaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaPreventivo->setIdPaziente($_GET['idPaziente']);
		$modificaPreventivo->setIdListino($_GET['idListino']);
		$modificaPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$modificaPreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$modificaPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$modificaPreventivo->setDataInserimento($_GET['datainserimento']);
		$modificaPreventivo->setStato($_GET['stato']);
		$modificaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$modificaPreventivo->setCognome($_GET['cognome']);
		$modificaPreventivo->setNome($_GET['nome']);
		$modificaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaPreventivo->setIdPaziente($_POST['idPaziente']);
		$modificaPreventivo->setIdListino($_POST['idListino']);
		$modificaPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$modificaPreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$modificaPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$modificaPreventivo->setDataInserimento($_POST['datainserimento']);
		$modificaPreventivo->setStato($_POST['stato']);
		$modificaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$modificaPreventivo->setCognome($_POST['cognome']);
		$modificaPreventivo->setNome($_POST['nome']);
		$modificaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaPreventivo->start();
if ($_GET['modo'] == "go") $modificaPreventivo->go();

?>