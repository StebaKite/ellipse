<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaPaziente.class.php';

$creaPaziente = new creaPaziente();

if ($_GET["modo"] == "start") $creaPaziente->start();
if ($_GET["modo"] == "go") $creaPaziente->go();

?>
