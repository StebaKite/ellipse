<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'cancellaNotaPreventivo.class.php';
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

	$cancellaNotaPreventivo = new cancellaNotaPreventivo();
	if ($_GET['modo'] == "start") $cancellaNotaPreventivo->start();
	if ($_GET['modo'] == "go") $cancellaNotaPreventivo->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idNotaPreventivo'] != "") $data['idNotaPreventivo'] = 'idnotapreventivo' . ';' . $_GET['idNotaPreventivo'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idNotaPreventivo'] = $_GET['idNotaPreventivo'];

		$cancellaNotaPreventivo = new cancellaNotaPreventivo();
		if ($_GET['modo'] == "start") $cancellaNotaPreventivo->start();
		if ($_GET['modo'] == "go") $cancellaNotaPreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>