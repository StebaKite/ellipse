<?php

set_include_path('/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'modificaConfig.class.php';

$modificaConfig = new modificaConfig();

if ($_GET["modo"] == "start") $modificaConfig->start();
if ($_GET["modo"] == "go") $modificaConfig->go();

?>
