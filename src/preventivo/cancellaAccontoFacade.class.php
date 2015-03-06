<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'cancellaAcconto.class.php';
require_once 'firewall.class.php';

/**
 * Avvio la sessione
 */
session_start();

/**
 * Controllo il secureCode in sessione
*/

if ($_SESSION['secureCode'] != '4406105963138001') exit('Errore di sessione') ;

/**
 * Controllo dei parametri passati nella request
*/

if ($_POST['usa-sessione']) {

	$cancellaAcconto = new cancellaAcconto();
	if ($_GET['modo'] == "start") $cancellaAcconto->start();
	if ($_GET['modo'] == "go") $cancellaAcconto->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idAcconto'] != "") $data['idAcconto'] = 'idAcconto' . ';' . $_GET['idAcconto'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idAcconto'] = $_GET['idAcconto'];

		$cancellaAcconto = new cancellaAcconto();
		if ($_GET['modo'] == "start") $cancellaAcconto->start();
		if ($_GET['modo'] == "go") $cancellaAcconto->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>