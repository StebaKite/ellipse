<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'modificaVisita.class.php';

$modificaVisita = new modificaVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaVisita->setIdPaziente($_GET['idPaziente']);
		$modificaVisita->setIdListino($_GET['idListino']);
		$modificaVisita->setIdVisita($_GET['idVisita']);
		$modificaVisita->setDataInserimento($_GET['datainserimento']);
		$modificaVisita->setStato($_GET['stato']);
		$modificaVisita->setCognomeRicerca($_GET['cognRic']);
		$modificaVisita->setCognome($_GET['cognome']);
		$modificaVisita->setNome($_GET['nome']);
		$modificaVisita->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaVisita->setIdPaziente($_POST['idPaziente']);
		$modificaVisita->setIdListino($_POST['idListino']);
		$modificaVisita->setIdVisita($_POST['idVisita']);
		$modificaVisita->setDataInserimento($_POST['datainserimento']);
		$modificaVisita->setStato($_POST['stato']);
		$modificaVisita->setCognomeRicerca($_POST['cognRic']);
		$modificaVisita->setCognome($_POST['cognome']);
		$modificaVisita->setNome($_POST['nome']);
		$modificaVisita->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaVisita->start();
if ($_GET['modo'] == "go") $modificaVisita->go();

?>
