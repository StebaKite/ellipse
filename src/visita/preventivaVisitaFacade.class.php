<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'preventivaVisita.class.php';

$preventivaVisita = new preventivaVisita();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$preventivaVisita->setIdPaziente($_GET['idPaziente']);
		$preventivaVisita->setIdListino($_GET['idListino']);
		$preventivaVisita->setIdVisita($_GET['idVisita']);
		$preventivaVisita->setDataInserimento($_GET['datainserimento']);
		$preventivaVisita->setStato($_GET['stato']);
		$preventivaVisita->setCognomeRicerca($_GET['cognRic']);
		$preventivaVisita->setCognome($_GET['cognome']);
		$preventivaVisita->setNome($_GET['nome']);
		$preventivaVisita->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$preventivaVisita->setIdPaziente($_POST['idPaziente']);
		$preventivaVisita->setIdListino($_POST['idListino']);
		$preventivaVisita->setIdVisita($_POST['idVisita']);
		$preventivaVisita->setDataInserimento($_POST['datainserimento']);
		$preventivaVisita->setStato($_POST['stato']);
		$preventivaVisita->setCognomeRicerca($_POST['cognRic']);
		$preventivaVisita->setCognome($_POST['cognome']);
		$preventivaVisita->setNome($_POST['nome']);
		$preventivaVisita->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $preventivaVisita->start();
if ($_GET['modo'] == "go") $preventivaVisita->go();

?>