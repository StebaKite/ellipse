<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'modificaPaziente.class.php';

$modificaPaziente = new modificaPaziente();
$modificaPaziente->setIdPaziente($_GET["idPaziente"]);
$modificaPaziente->setCognomeRicerca($_GET["cognRic"]);

if ($_GET["modo"] == "start") $modificaPaziente->start();
if ($_GET["modo"] == "go") $modificaPaziente->go();

?>
