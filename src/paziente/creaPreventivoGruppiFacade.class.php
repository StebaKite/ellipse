<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'creaPreventivo.gruppi.class.php';

$creaPreventivoGruppi = new creaPreventivoGruppi();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaPreventivoGruppi->setIdPaziente($_GET['idPaziente']);
		$creaPreventivoGruppi->setIdListino($_GET['idListino']);
		$creaPreventivoGruppi->setCognomeRicerca($_GET['cognRic']);
		$creaPreventivoGruppi->setCognome($_GET['cognome']);
		$creaPreventivoGruppi->setNome($_GET['nome']);
		$creaPreventivoGruppi->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$creaPreventivoGruppi->setIdPaziente($_POST['idPaziente']);
		$creaPreventivoGruppi->setIdListino($_POST['idListino']);
		$creaPreventivoGruppi->setCognomeRicerca($_POST['cognRic']);
		$creaPreventivoGruppi->setCognome($_POST['cognome']);
		$creaPreventivoGruppi->setNome($_POST['nome']);
		$creaPreventivoGruppi->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaPreventivoGruppi->start();
if ($_GET['modo'] == "go") $creaPreventivoGruppi->go();

?>