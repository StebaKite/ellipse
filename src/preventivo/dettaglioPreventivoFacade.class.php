<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'dettaglioPreventivo.class.php';

$dettaglioPreventivo = new dettaglioPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$dettaglioPreventivo->setIdPaziente($_GET['idPaziente']);
		$dettaglioPreventivo->setIdListino($_GET['idListino']);
		$dettaglioPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$dettaglioPreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$dettaglioPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$dettaglioPreventivo->setNomeForm($_GET['nomeform']);
		$dettaglioPreventivo->setNomeCampoForm($_GET['nomecampoform']);
		$dettaglioPreventivo->setCodiceVoceListino($_GET['codicevocelistino']);
		$dettaglioPreventivo->setDataInserimento($_GET['datainserimento']);
		$dettaglioPreventivo->setStato($_GET['stato']);
		$dettaglioPreventivo->setCognomeRicerca($_GET['cognRic']);
		$dettaglioPreventivo->setCognome($_GET['cognome']);
		$dettaglioPreventivo->setNome($_GET['nome']);
		$dettaglioPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$dettaglioPreventivo->setIdPaziente($_POST['idPaziente']);
		$dettaglioPreventivo->setIdListino($_POST['idListino']);
		$dettaglioPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$dettaglioPreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$dettaglioPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$dettaglioPreventivo->setNomeForm($_POST['nomeform']);
		$dettaglioPreventivo->setNomeCampoForm($_POST['nomecampoform']);
		$dettaglioPreventivo->setCodiceVoceListino($_POST['codicevocelistino']);
		$dettaglioPreventivo->setDataInserimento($_POST['datainserimento']);
		$dettaglioPreventivo->setStato($_POST['stato']);
		$dettaglioPreventivo->setCognomeRicerca($_POST['cognRic']);
		$dettaglioPreventivo->setCognome($_POST['cognome']);
		$dettaglioPreventivo->setNome($_POST['nome']);
		$dettaglioPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $dettaglioPreventivo->start();
if ($_GET['modo'] == "go") $dettaglioPreventivo->go();

?>