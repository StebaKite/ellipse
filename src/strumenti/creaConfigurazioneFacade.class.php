<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'creaConfigurazione.class.php';

$creaConfigurazione = new creaConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaConfigurazione->setProgressivo($_GET['progressivo']);
		$creaConfigurazione->setClasse($_GET['classe']);
		$creaConfigurazione->setFilepath($_GET['filepath']);
		$creaConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$creaConfigurazione->setProgressivo($_POST['progressivo']);
		$creaConfigurazione->setClasse($_POST['classe']);
		$creaConfigurazione->setFilepath($_POST['filepath']);
		$creaConfigurazione->setStato($_POST['stato']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaConfigurazione->start();
if ($_GET['modo'] == "go") $creaConfigurazione->go();

?>