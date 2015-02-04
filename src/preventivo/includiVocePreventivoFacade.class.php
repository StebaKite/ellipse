<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'includiVocePreventivo.class.php';

$includiVocePreventivo = new includiVocePreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$includiVocePreventivo->setIdPaziente($_GET['idpaziente']);
		$includiVocePreventivo->setIdListino($_GET['idlistino']);
		$includiVocePreventivo->setCognomeRicerca($_GET['cognRic']);
		$includiVocePreventivo->setCognome($_GET['cognome']);
		$includiVocePreventivo->setNome($_GET['nome']);
		$includiVocePreventivo->setDataNascita($_GET['datanascita']);
		
		$includiVocePreventivo->setIdPreventivo($_GET['idpreventivo']);
		$includiVocePreventivo->setIdSottoPreventivo($_GET['idsottopreventivo']);
		$includiVocePreventivo->setDataInserimento($_GET['datainserimento']);
		$includiVocePreventivo->setStato($_GET['stato']);
		$includiVocePreventivo->setPrezzo($_GET['prezzo']);
		$includiVocePreventivo->setNomeForm($_GET['nomeform']);
		$includiVocePreventivo->setNomeCampoForm($_GET['nomecampoform']);
		$includiVocePreventivo->setCodiceVoceListino($_GET['codicevocelistino']);
		$includiVocePreventivo->setIdVocePreventivo($_GET['idvocepreventivo']);
		$includiVocePreventivo->setIdVoceSottoPreventivo($_GET['idvocesottopreventivo']);
		break;
	case 'POST':
		$includiVocePreventivo->setIdPaziente($_POST['idpaziente']);
		$includiVocePreventivo->setIdListino($_POST['idlistino']);
		$includiVocePreventivo->setCognomeRicerca($_POST['cognRic']);
		$includiVocePreventivo->setCognome($_POST['cognome']);
		$includiVocePreventivo->setNome($_POST['nome']);
		$includiVocePreventivo->setDataNascita($_POST['datanascita']);
		
		$includiVocePreventivo->setIdPreventivo($_POST['idpreventivo']);
		$includiVocePreventivo->setIdSottoPreventivo($_POST['idsottopreventivo']);
		$includiVocePreventivo->setDataInserimento($_POST['datainserimento']);
		$includiVocePreventivo->setStato($_POST['stato']);
		$includiVocePreventivo->setPrezzo($_POST['prezzo']);
		$includiVocePreventivo->setNomeForm($_POST['nomeform']);
		$includiVocePreventivo->setNomeCampoForm($_POST['nomecampoform']);
		$includiVocePreventivo->setCodiceVoceListino($_POST['codicevocelistino']);
		$includiVocePreventivo->setIdVocePreventivo($_POST['idvocepreventivo']);
		$includiVocePreventivo->setIdVoceSottoPreventivo($_POST['idvocesottopreventivo']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $includiVocePreventivo->start();
if ($_GET['modo'] == "go") $includiVocePreventivo->go();

?>