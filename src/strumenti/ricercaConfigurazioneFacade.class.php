<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'ricercaConfigurazioni.class.php';

$ricercaConfigurazioni = new ricercaConfigurazioni();

if ($_GET["modo"] == "start") $ricercaConfigurazioni->start();
if ($_GET["modo"] == "go") $ricercaConfigurazioni->go();

?>