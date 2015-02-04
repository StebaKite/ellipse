<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'splitPreventivo.class.php';

$splitPreventivo = new splitPreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$splitPreventivo->setIdPaziente($_GET['idPaziente']);
		$splitPreventivo->setIdListino($_GET['idListino']);
		$splitPreventivo->setIdPreventivo($_GET['idPreventivo']);
		$splitPreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$splitPreventivo->setNomeForm($_GET['nomeform']);
		$splitPreventivo->setNomeCampoForm($_GET['nomecampoform']);
		$splitPreventivo->setCodiceVoceListino($_GET['codicevocelistino']);
		$splitPreventivo->setDataInserimento($_GET['datainserimento']);
		$splitPreventivo->setStato($_GET['stato']);
		$splitPreventivo->setCognomeRicerca($_GET['cognRic']);
		$splitPreventivo->setCognome($_GET['cognome']);
		$splitPreventivo->setNome($_GET['nome']);
		$splitPreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$splitPreventivo->setIdPaziente($_POST['idPaziente']);
		$splitPreventivo->setIdListino($_POST['idListino']);
		$splitPreventivo->setIdPreventivo($_POST['idPreventivo']);
		$splitPreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$splitPreventivo->setNomeForm($_POST['nomeform']);
		$splitPreventivo->setNomeCampoForm($_POST['nomecampoform']);
		$splitPreventivo->setCodiceVoceListino($_POST['codicevocelistino']);
		$splitPreventivo->setDataInserimento($_POST['datainserimento']);
		$splitPreventivo->setStato($_POST['stato']);
		$splitPreventivo->setCognomeRicerca($_POST['cognRic']);
		$splitPreventivo->setCognome($_POST['cognome']);
		$splitPreventivo->setNome($_POST['nome']);
		$splitPreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $splitPreventivo->start();
if ($_GET['modo'] == "go") $splitPreventivo->go();

?>