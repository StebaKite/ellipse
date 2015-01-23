<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'menubanner.class.php';

error_log(">>>>>> Facade <<<<<<<");

$menubanner = new menubanner();

if ($_GET["modo"] == "start") $menubanner->start();
if ($_GET["modo"] == "go") $menubanner->go();

?>
