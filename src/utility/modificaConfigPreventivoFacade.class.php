<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/utility');
require_once 'modificaConfigPreventivo.class.php';

$modificaConfigPreventivo = new modificaConfigPreventivo();

if ($_GET["modo"] == "start") $modificaConfigPreventivo->start();
if ($_GET["modo"] == "go") $modificaConfigPreventivo->go();

?>