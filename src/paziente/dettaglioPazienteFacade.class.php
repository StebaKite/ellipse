<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'dettaglioPaziente.class.php';

$dettaglioPaziente = new dettaglioPaziente();

$dettaglioPaziente->setIdPaziente($_GET["idPaziente"]);
$dettaglioPaziente->setCognomeRicerca($_GET["cognRic"]);

if ($_GET["modo"] == "start") $dettaglioPaziente->start();
if ($_GET["modo"] == "go") $dettaglioPaziente->go();

?>

