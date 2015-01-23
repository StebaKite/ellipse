<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.class.php';

$creaVisita = new creaVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaVisita->setIdPaziente($_GET['idPaziente']);
		$creaVisita->setIdListino($_GET['idListino']);
		$creaVisita->setCognomeRicerca($_GET['cognRic']);
		$creaVisita->setCognome($_GET['cognome']);
		$creaVisita->setNome($_GET['nome']);
		$creaVisita->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$creaVisita->setIdPaziente($_POST['idPaziente']);
		$creaVisita->setIdListino($_POST['idListino']);
		$creaVisita->setCognomeRicerca($_POST['cognRic']);
		$creaVisita->setCognome($_POST['cognome']);
		$creaVisita->setNome($_POST['nome']);
		$creaVisita->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaVisita->start();
if ($_GET['modo'] == "go") $creaVisita->go();

?>
