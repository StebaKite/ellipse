<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'modificaConfigurazione.class.php';

$modificaConfigurazione = new modificaConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaConfigurazione->setIdguida($_GET['idguida']);
		$modificaConfigurazione->setProgressivo($_GET['progressivo']);
		$modificaConfigurazione->setClasse($_GET['classe']);
		$modificaConfigurazione->setFilepath($_GET['filepath']);
		$modificaConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$modificaConfigurazione->setIdguida($_POST['idguida']);
		$modificaConfigurazione->setProgressivo($_POST['progressivo']);
		$modificaConfigurazione->setClasse($_POST['classe']);
		$modificaConfigurazione->setFilepath($_POST['filepath']);
		$modificaConfigurazione->setStato($_POST['stato']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaConfigurazione->start();
if ($_GET['modo'] == "go") $modificaConfigurazione->go();

?>