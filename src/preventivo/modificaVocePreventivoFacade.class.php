<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaVocePreventivo.class.php';

$modificaVocePreventivo = new modificaVocePreventivo();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaVocePreventivo->setIdPaziente($_GET['idPaziente']);
		$modificaVocePreventivo->setIdListino($_GET['idListino']);
		$modificaVocePreventivo->setDescrizioneVoce($_GET['descrizionevoce']);
		$modificaVocePreventivo->setDescrizioneVoceListino($_GET['descrizionevocelistino']);
		$modificaVocePreventivo->setPrezzo($_GET['prezzo']);
		$modificaVocePreventivo->setIdVocePreventivo($_GET['idvocepreventivo']);
		$modificaVocePreventivo->setIdVoceSottoPreventivo($_GET['idvocesottopreventivo']);
		$modificaVocePreventivo->setIdPreventivo($_GET['idPreventivo']);
		$modificaVocePreventivo->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$modificaVocePreventivo->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$modificaVocePreventivo->setDataInserimento($_GET['datainserimento']);
		$modificaVocePreventivo->setStato($_GET['stato']);
		$modificaVocePreventivo->setTabella($_GET['tabella']);
		$modificaVocePreventivo->setDente($_GET['dente']);
		$modificaVocePreventivo->setCognomeRicerca($_GET['cognRic']);
		$modificaVocePreventivo->setCognome($_GET['cognome']);
		$modificaVocePreventivo->setNome($_GET['nome']);
		$modificaVocePreventivo->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaVocePreventivo->setIdPaziente($_POST['idPaziente']);
		$modificaVocePreventivo->setIdListino($_POST['idListino']);
		$modificaVocePreventivo->setDescrizioneVoce($_POST['descrizionevoce']);
		$modificaVocePreventivo->setDescrizioneVoceListino($_POST['descrizionevocelistino']);
		$modificaVocePreventivo->setPrezzo($_POST['prezzo']);
		$modificaVocePreventivo->setIdVocePreventivo($_POST['idvocepreventivo']);
		$modificaVocePreventivo->setIdVoceSottoPreventivo($_POST['idvocesottopreventivo']);
		$modificaVocePreventivo->setIdPreventivo($_POST['idPreventivo']);
		$modificaVocePreventivo->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$modificaVocePreventivo->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$modificaVocePreventivo->setDataInserimento($_POST['datainserimento']);
		$modificaVocePreventivo->setStato($_POST['stato']);
		$modificaVocePreventivo->setTabella($_POST['tabella']);
		$modificaVocePreventivo->setDente($_POST['dente']);
		$modificaVocePreventivo->setCognomeRicerca($_POST['cognRic']);
		$modificaVocePreventivo->setCognome($_POST['cognome']);
		$modificaVocePreventivo->setNome($_POST['nome']);
		$modificaVocePreventivo->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaVocePreventivo->start();
if ($_GET['modo'] == "go") $modificaVocePreventivo->go();

?>