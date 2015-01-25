<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'ricercaListino.class.php';

$ricercaListino = new ricercaListino();

if ($_GET["modo"] == "start") $ricercaListino->start();
if ($_GET["modo"] == "go") $ricercaListino->go();

?>