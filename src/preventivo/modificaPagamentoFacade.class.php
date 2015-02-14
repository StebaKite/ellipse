<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaPagamento.class.php';

$modificaPagamento = new modificaPagamento();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaPagamento->setIdPaziente($_GET['idPaziente']);
		$modificaPagamento->setIdListino($_GET['idListino']);
		$modificaPagamento->setIdPreventivo($_GET['idPreventivo']);
		$modificaPagamento->setIdPreventivoPrincipale($_GET['idPreventivoPrincipale']);
		$modificaPagamento->setIdSottoPreventivo($_GET['idSottoPreventivo']);
		$modificaPagamento->setDataInserimento($_GET['datainserimento']);
		$modificaPagamento->setStato($_GET['stato']);
		$modificaPagamento->setCognomeRicerca($_GET['cognRic']);
		$modificaPagamento->setCognome($_GET['cognome']);
		$modificaPagamento->setNome($_GET['nome']);
		$modificaPagamento->setDataNascita($_GET['datanascita']);
		break;
	case 'POST':
		$modificaPagamento->setIdPaziente($_POST['idPaziente']);
		$modificaPagamento->setIdListino($_POST['idListino']);
		$modificaPagamento->setIdPreventivo($_POST['idPreventivo']);
		$modificaPagamento->setIdPreventivoPrincipale($_POST['idPreventivoPrincipale']);
		$modificaPagamento->setIdSottoPreventivo($_POST['idSottoPreventivo']);
		$modificaPagamento->setDataInserimento($_POST['datainserimento']);
		$modificaPagamento->setStato($_POST['stato']);
		$modificaPagamento->setCognomeRicerca($_POST['cognRic']);
		$modificaPagamento->setCognome($_POST['cognome']);
		$modificaPagamento->setNome($_POST['nome']);
		$modificaPagamento->setDataNascita($_POST['datanascita']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaPagamento->start();
if ($_GET['modo'] == "go") $modificaPagamento->go();

?>