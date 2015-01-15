<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'cancellaRegolaConfigurazione.class.php';

$cancellaRegolaConfigurazione = new cancellaRegolaConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaRegolaConfigurazione->setIddettaglioguida($_GET['iddettaglioguida']);
		$cancellaRegolaConfigurazione->setColonna($_GET['colonna']);
		$cancellaRegolaConfigurazione->setPosizionevalore($_GET['posizionevalore']);
		$cancellaRegolaConfigurazione->setIdguida($_GET['idguida']);
		$cancellaRegolaConfigurazione->setProgressivo($_GET['progressivo']);
		$cancellaRegolaConfigurazione->setClasse($_GET['classe']);
		$cancellaRegolaConfigurazione->setFilepath($_GET['filepath']);
		$cancellaRegolaConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$cancellaRegolaConfigurazione->setIddettaglioguida($_POST['iddettaglioguida']);
		$cancellaRegolaConfigurazione->setColonna($_POST['colonna']);
		$cancellaRegolaConfigurazione->setPosizionevalore($_POST['posizionevalore']);
		$cancellaRegolaConfigurazione->setIdguida($_POST['idguida']);
		$cancellaRegolaConfigurazione->setProgressivo($_POST['progressivo']);
		$cancellaRegolaConfigurazione->setClasse($_POST['classe']);
		$cancellaRegolaConfigurazione->setFilepath($_POST['filepath']);
		$cancellaRegolaConfigurazione->setStato($_POST['stato']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaRegolaConfigurazione->start();
if ($_GET['modo'] == "go") $cancellaRegolaConfigurazione->go();

?>