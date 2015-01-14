<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'cancellaConfigurazione.class.php';

$cancellaConfigurazione = new cancellaConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaConfigurazione->setIdguida($_GET['idguida']);
		$cancellaConfigurazione->setProgressivo($_GET['progressivo']);
		$cancellaConfigurazione->setClasse($_GET['classe']);
		$cancellaConfigurazione->setFilepath($_GET['filepath']);
		$cancellaConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$cancellaConfigurazione->setIdguida($_POST['idguida']);
		$cancellaConfigurazione->setProgressivo($_POST['progressivo']);
		$cancellaConfigurazione->setClasse($_POST['classe']);
		$cancellaConfigurazione->setFilepath($_POST['filepath']);
		$cancellaConfigurazione->setStato($_POST['stato']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaConfigurazione->start();
if ($_GET['modo'] == "go") $cancellaConfigurazione->go();

?>