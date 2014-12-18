<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.class.php';

$creaVisita = new creaVisita();

$creaVisita->setIdPaziente($_GET['idPaziente']);
$creaVisita->setIdListino($_GET['idListino']);

if ($_GET['modo'] == "start") $creaVisita->start();
if ($_GET['modo'] == "go") {
	
	if ($_GET['tipo'] == "singoli") $creaVisita->goSingoli();
	if ($_GET['tipo'] == "gruppi") $creaVisita->goGruppi();
	if ($_GET['tipo'] == "cure") $creaVisita->goCure();
}

?>
