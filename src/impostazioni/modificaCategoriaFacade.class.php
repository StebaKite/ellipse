<?php

set_include_path('/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'modificaCategoria.class.php';

$modificaCategoria = new modificaCategoria();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
	case 'GET':
		$modificaCategoria->setIdcategoria($_GET['idcategoria']);
		$modificaCategoria->setCodiceCategoria($_GET['codicecategoria']);
		$modificaCategoria->setDescrizioneCategoria($_GET['descrizionecategoria']);
		break;
	case 'POST':
		$modificaCategoria->setIdcategoria($_POST['idcategoria']);
		$modificaCategoria->setCodiceCategoria($_POST['codicecategoria']);
		$modificaCategoria->setDescrizioneCategoria($_POST['descrizionecategoria']);
		break;
	default:
		error_log("ERRORE: tipo di chiamata REST non previsto!!");
		break;
}

if ($_GET['modo'] == "start") $modificaCategoria->start();
if ($_GET['modo'] == "go") $modificaCategoria->go();

?>