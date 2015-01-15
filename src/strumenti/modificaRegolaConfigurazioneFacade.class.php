<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'modificaRegolaConfigurazione.class.php';

$modificaRegolaConfigurazione = new modificaRegolaConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaRegolaConfigurazione->setIddettaglioguida($_GET['iddettaglioguida']);
		$modificaRegolaConfigurazione->setColonna($_GET['colonna']);
		$modificaRegolaConfigurazione->setPosizionevalore($_GET['posizionevalore']);
		$modificaRegolaConfigurazione->setIdguida($_GET['idguida']);
		$modificaRegolaConfigurazione->setProgressivo($_GET['progressivo']);
		$modificaRegolaConfigurazione->setClasse($_GET['classe']);
		$modificaRegolaConfigurazione->setFilepath($_GET['filepath']);
		$modificaRegolaConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$modificaRegolaConfigurazione->setIddettaglioguida($_POST['iddettaglioguida']);
		$modificaRegolaConfigurazione->setColonna($_POST['colonna']);
		$modificaRegolaConfigurazione->setPosizionevalore($_POST['posizionevalore']);
		$modificaRegolaConfigurazione->setIdguida($_POST['idguida']);
		$modificaRegolaConfigurazione->setProgressivo($_POST['progressivo']);
		$modificaRegolaConfigurazione->setClasse($_POST['classe']);
		$modificaRegolaConfigurazione->setFilepath($_POST['filepath']);
		$modificaRegolaConfigurazione->setStato($_POST['stato']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaRegolaConfigurazione->start();
if ($_GET['modo'] == "go") $modificaRegolaConfigurazione->go();

?>