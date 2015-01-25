<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'cancellaVoce.class.php';

$cancellaVoce = new cancellaVoce();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$cancellaVoce->setIdvoce($_GET['idvoce']);
		$cancellaVoce->setIdcategoria($_GET['idcategoria']);
		$cancellaVoce->setCodiceCategoria($_GET['codicecategoria']);
		$cancellaVoce->setDescrizioneCategoria($_GET['descrizionecategoria']);
		$cancellaVoce->setCodiceVoce($_GET['codicevoce']);
		$cancellaVoce->setDescrizioneVoce($_GET['descrizionevoce']);
		$cancellaVoce->setPrezzo($_GET['prezzo']);
		$cancellaVoce->setTipoVoce($_GET['tipovoce']);
		break;
	case 'POST':
		$cancellaVoce->setIdvoce($_POST['idvoce']);
		$cancellaVoce->setIdcategoria($_POST['idcategoria']);
		$cancellaVoce->setCodiceCategoria($_POST['codicecategoria']);
		$cancellaVoce->setDescrizioneCategoria($_POST['descrizionecategoria']);
		$cancellaVoce->setCodiceVoce($_POST['codicevoce']);
		$cancellaVoce->setDescrizioneVoce($_POST['descrizionevoce']);
		$cancellaVoce->setPrezzo($_POST['prezzo']);
		$cancellaVoce->setTipoVoce($_POST['tipovoce']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $cancellaVoce->start();
if ($_GET['modo'] == "go") $cancellaVoce->go();

?>