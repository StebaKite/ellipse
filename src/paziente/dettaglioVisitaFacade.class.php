<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'dettaglioVisita.class.php';

$dettaglioVisita = new dettaglioVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$dettaglioVisita->setIdPaziente($_GET['idPaziente']);
		$dettaglioVisita->setIdVisita($_GET['idVisita']);
		$dettaglioVisita->setDataInserimento($_GET['datainserimento']);
		$dettaglioVisita->setStato($_GET['stato']);
		$dettaglioVisita->setCognomeRicerca($_GET['cognRic']);
		$dettaglioVisita->setCognome($_GET['cognome']);
		$dettaglioVisita->setNome($_GET['nome']);
		$dettaglioVisita->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$dettaglioVisita->setIdPaziente($_POST['idPaziente']);
		$dettaglioVisita->setIdVisita($_POST['idVisita']);
		$dettaglioVisita->setDataInserimento($_POST['datainserimento']);
		$dettaglioVisita->setStato($_POST['stato']);
		$dettaglioVisita->setCognomeRicerca($_POST['cognRic']);
		$dettaglioVisita->setCognome($_POST['cognome']);
		$dettaglioVisita->setNome($_POST['nome']);
		$dettaglioVisita->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $dettaglioVisita->start();
if ($_GET['modo'] == "go") $dettaglioVisita->go();

?>
