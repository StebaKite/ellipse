<?php

set_include_path('/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'ricercaCategoria.class.php';

$ricercaCategoria = new ricercaCategoria();

if ($_GET["modo"] == "start") $ricercaCategoria->start();
if ($_GET["modo"] == "go") $ricercaCategoria->go();

?>