<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'ricercaPaziente.class.php';

$ricercaPaziente = new ricercaPaziente();

if ($_GET["modo"] == "start") $ricercaPaziente->start();
if ($_GET["modo"] == "go") $ricercaPaziente->go();

?>
