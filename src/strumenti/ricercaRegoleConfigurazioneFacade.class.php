<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'ricercaRegoleConfigurazione.class.php';

$ricercaRegoleConfigurazione = new ricercaRegoleConfigurazione();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$ricercaRegoleConfigurazione->setIdguida($_GET['idguida']);
		$ricercaRegoleConfigurazione->setProgressivo($_GET['progressivo']);
		$ricercaRegoleConfigurazione->setClasse($_GET['classe']);
		$ricercaRegoleConfigurazione->setFilepath($_GET['filepath']);
		$ricercaRegoleConfigurazione->setStato($_GET['stato']);
		break;
	case 'POST':
		$ricercaRegoleConfigurazione->setIdguida($_POST['idguida']);
		$ricercaRegoleConfigurazione->setProgressivo($_POST['progressivo']);
		$ricercaRegoleConfigurazione->setClasse($_POST['classe']);
		$ricercaRegoleConfigurazione->setFilepath($_POST['filepath']);
		$ricercaRegoleConfigurazione->setStato($_POST['stato']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $ricercaRegoleConfigurazione->start();
if ($_GET['modo'] == "go") $ricercaRegoleConfigurazione->go();

?>