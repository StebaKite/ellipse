<?php

set_include_path('/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'creaVoce.class.php';

$creaVoce = new creaVoce();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$creaVoce->setIdvoce($_GET['idvoce']);
		$creaVoce->setIdcategoria($_GET['idcategoria']);
		$creaVoce->setCodiceCategoria($_GET['codicecategoria']);
		$creaVoce->setDescrizioneCategoria($_GET['descrizionecategoria']);
		$creaVoce->setCodiceVoce($_GET['codicevoce']);
		$creaVoce->setDescrizioneVoce($_GET['descrizionevoce']);
		$creaVoce->setPrezzo($_GET['prezzo']);
		$creaVoce->setTipoVoce($_GET['tipovoce']);
		break;
	case 'POST':
		$creaVoce->setIdvoce($_POST['idvoce']);
		$creaVoce->setIdcategoria($_POST['idcategoria']);
		$creaVoce->setCodiceCategoria($_POST['codicecategoria']);
		$creaVoce->setDescrizioneCategoria($_POST['descrizionecategoria']);
		$creaVoce->setCodiceVoce($_POST['codicevoce']);
		$creaVoce->setDescrizioneVoce($_POST['descrizionevoce']);
		$creaVoce->setPrezzo($_POST['prezzo']);
		$creaVoce->setTipoVoce($_POST['tipovoce']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $creaVoce->start();
if ($_GET['modo'] == "go") $creaVoce->go();

?>