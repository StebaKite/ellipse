<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'cancellaPaziente.class.php';

$cancellaPaziente = new cancellaPaziente();

$cancellaPaziente->setIdPaziente($_GET["idPaziente"]);
$cancellaPaziente->setCognomeRicerca($_GET["cognRic"]);

if ($_GET["modo"] == "start") $cancellaPaziente->start();
if ($_GET["modo"] == "go") $cancellaPaziente->go();

?>
