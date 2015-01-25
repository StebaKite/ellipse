<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'cancellaVisita.class.php';

$cancellaVisita = new cancellaVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaVisita->setIdPaziente($_GET['idPaziente']);
		$cancellaVisita->setIdListino($_GET['idListino']);
		$cancellaVisita->setIdVisita($_GET['idVisita']);
		$cancellaVisita->setDataInserimento($_GET['datainserimento']);
		$cancellaVisita->setStato($_GET['stato']);
		$cancellaVisita->setCognomeRicerca($_GET['cognRic']);
		$cancellaVisita->setCognome($_GET['cognome']);
		$cancellaVisita->setNome($_GET['nome']);
		$cancellaVisita->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$cancellaVisita->setIdPaziente($_POST['idPaziente']);
		$cancellaVisita->setIdListino($_POST['idListino']);
		$cancellaVisita->setIdVisita($_POST['idVisita']);
		$cancellaVisita->setDataInserimento($_POST['datainserimento']);
		$cancellaVisita->setStato($_POST['stato']);
		$cancellaVisita->setCognomeRicerca($_POST['cognRic']);
		$cancellaVisita->setCognome($_POST['cognome']);
		$cancellaVisita->setNome($_POST['nome']);
		$cancellaVisita->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaVisita->start();
if ($_GET['modo'] == "go") $cancellaVisita->go();

?>
