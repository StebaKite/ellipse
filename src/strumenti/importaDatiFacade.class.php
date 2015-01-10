<?php

set_include_path('/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'importaDati.class.php';

$importaDati = new importaDati();

if ($_GET["modo"] == "start") $importaDati->start();
if ($_GET["modo"] == "go") $importaDati->go();

?>