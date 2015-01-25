<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'modificaVoce.class.php';

$modificaVoce = new modificaVoce();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaVoce->setIdvoce($_GET['idvoce']);
		$modificaVoce->setIdcategoria($_GET['idcategoria']);
		$modificaVoce->setCodiceCategoria($_GET['codicecategoria']);
		$modificaVoce->setDescrizioneCategoria($_GET['descrizionecategoria']);
		$modificaVoce->setCodiceVoce($_GET['codicevoce']);
		$modificaVoce->setDescrizioneVoce($_GET['descrizionevoce']);
		$modificaVoce->setPrezzo($_GET['prezzo']);
		$modificaVoce->setTipoVoce($_GET['tipovoce']);
		break;
	case 'POST':
		$modificaVoce->setIdvoce($_POST['idvoce']);
		$modificaVoce->setIdcategoria($_POST['idcategoria']);
		$modificaVoce->setCodiceCategoria($_POST['codicecategoria']);
		$modificaVoce->setDescrizioneCategoria($_POST['descrizionecategoria']);
		$modificaVoce->setCodiceVoce($_POST['codicevoce']);
		$modificaVoce->setDescrizioneVoce($_POST['descrizionevoce']);
		$modificaVoce->setPrezzo($_POST['prezzo']);
		$modificaVoce->setTipoVoce($_POST['tipovoce']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaVoce->start();
if ($_GET['modo'] == "go") $modificaVoce->go();

?>