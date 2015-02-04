<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'escludiVocePreventivo.class.php';

$escludiVocePreventivo = new escludiVocePreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$escludiVocePreventivo->setIdPaziente($_GET['idpaziente']);
		$escludiVocePreventivo->setIdListino($_GET['idlistino']);
		$escludiVocePreventivo->setCognomeRicerca($_GET['cognRic']);
		$escludiVocePreventivo->setCognome($_GET['cognome']);
		$escludiVocePreventivo->setNome($_GET['nome']);
		$escludiVocePreventivo->setDataNascita($_GET['datanascita']);

		$escludiVocePreventivo->setIdPreventivo($_GET['idpreventivo']);
		$escludiVocePreventivo->setIdSottoPreventivo($_GET['idsottopreventivo']);
		$escludiVocePreventivo->setDataInserimento($_GET['datainserimento']);
		$escludiVocePreventivo->setStato($_GET['stato']);
		$escludiVocePreventivo->setPrezzo($_GET['prezzo']);
		$escludiVocePreventivo->setNomeForm($_GET['nomeform']);
		$escludiVocePreventivo->setNomeCampoForm($_GET['nomecampoform']);
		$escludiVocePreventivo->setCodiceVoceListino($_GET['codicevocelistino']);
		$escludiVocePreventivo->setIdVocePreventivo($_GET['idvocepreventivo']);
		$escludiVocePreventivo->setIdVoceSottoPreventivo($_GET['idvocesottopreventivo']);
		break;
	case 'POST':
		$escludiVocePreventivo->setIdPaziente($_POST['idpaziente']);
		$escludiVocePreventivo->setIdListino($_POST['idlistino']);
		$escludiVocePreventivo->setCognomeRicerca($_POST['cognRic']);
		$escludiVocePreventivo->setCognome($_POST['cognome']);
		$escludiVocePreventivo->setNome($_POST['nome']);
		$escludiVocePreventivo->setDataNascita($_POST['datanascita']);

		$escludiVocePreventivo->setIdPreventivo($_POST['idpreventivo']);
		$escludiVocePreventivo->setIdSottoPreventivo($_POST['idsottopreventivo']);
		$escludiVocePreventivo->setDataInserimento($_POST['datainserimento']);
		$escludiVocePreventivo->setStato($_POST['stato']);
		$escludiVocePreventivo->setPrezzo($_POST['prezzo']);
		$escludiVocePreventivo->setNomeForm($_POST['nomeform']);
		$escludiVocePreventivo->setNomeCampoForm($_POST['nomecampoform']);
		$escludiVocePreventivo->setCodiceVoceListino($_POST['codicevocelistino']);
		$escludiVocePreventivo->setIdVocePreventivo($_POST['idvocepreventivo']);
		$escludiVocePreventivo->setIdVoceSottoPreventivo($_POST['idvocesottopreventivo']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $escludiVocePreventivo->start();
if ($_GET['modo'] == "go") $escludiVocePreventivo->go();

?>