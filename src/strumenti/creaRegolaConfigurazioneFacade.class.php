<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'creaRegolaConfigurazione.class.php';

$creaRegolaConfigurazione = new creaRegolaConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaRegolaConfigurazione->setIdguida($_GET['idguida']);
		$creaRegolaConfigurazione->setProgressivo($_GET['progressivo']);
		$creaRegolaConfigurazione->setClasse($_GET['classe']);
		$creaRegolaConfigurazione->setFilepath($_GET['filepath']);
		$creaRegolaConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$creaRegolaConfigurazione->setIdguida($_POST['idguida']);
		$creaRegolaConfigurazione->setProgressivo($_POST['progressivo']);
		$creaRegolaConfigurazione->setClasse($_POST['classe']);
		$creaRegolaConfigurazione->setFilepath($_POST['filepath']);
		$creaRegolaConfigurazione->setStato($_POST['stato']);
		$creaRegolaConfigurazione->setColonna($_POST['colonna']);
		$creaRegolaConfigurazione->setPosizioneValore($_POST['posizionevalore']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaRegolaConfigurazione->start();
if ($_GET['modo'] == "go") $creaRegolaConfigurazione->go();

?>