<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'stampaPreventivo.class.php';

$stampaPreventivo = new stampaPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$stampaPreventivo->setIdPaziente($_GET['idPaziente']);
		$stampaPreventivo->setIdListino($_GET['idListino']);
		$stampaPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$stampaPreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$stampaPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$stampaPreventivo->setNomeForm($_GET['nomeform']);
		$stampaPreventivo->setNomeCampoForm($_GET['nomecampoform']);
		$stampaPreventivo->setCodiceVoceListino($_GET['codicevocelistino']);
		$stampaPreventivo->setDataInserimento($_GET['datainserimento']);
		$stampaPreventivo->setStato($_GET['stato']);
		$stampaPreventivo->setCognomeRicerca($_GET['cognRic']);
		$stampaPreventivo->setCognome($_GET['cognome']);
		$stampaPreventivo->setNome($_GET['nome']);
		$stampaPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$stampaPreventivo->setIdPaziente($_POST['idPaziente']);
		$stampaPreventivo->setIdListino($_POST['idListino']);
		$stampaPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$stampaPreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$stampaPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$stampaPreventivo->setNomeForm($_POST['nomeform']);
		$stampaPreventivo->setNomeCampoForm($_POST['nomecampoform']);
		$stampaPreventivo->setCodiceVoceListino($_POST['codicevocelistino']);
		$stampaPreventivo->setDataInserimento($_POST['datainserimento']);
		$stampaPreventivo->setStato($_POST['stato']);
		$stampaPreventivo->setCognomeRicerca($_POST['cognRic']);
		$stampaPreventivo->setCognome($_POST['cognome']);
		$stampaPreventivo->setNome($_POST['nome']);
		$stampaPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $stampaPreventivo->start();
if ($_GET['modo'] == "go") $stampaPreventivo->go();

?>