<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'creaNotaVocePreventivo.class.php';
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

	$firewall = new firewall();

	$data = array();
	if ($_POST['notapreventivo'] != "") $data['notaPreventivo'] = 'notapreventivo' . ';' . $_POST['notapreventivo'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['notapreventivo'] = $_POST['notapreventivo'];

		$creaNotaVocePreventivo = new creaNotaVocePreventivo();
		if ($_GET['modo'] == "start") $creaNotaVocePreventivo->start();
		if ($_GET['modo'] == "go") $creaNotaVocePreventivo->go();
	}
	else {
		echo 'ATTENZIONE! Parametro non corretto';
	}
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_POST['notapreventivo'] != "") $data['notaPreventivo'] = 'notapreventivo' . ';' . $_POST['notapreventivo'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['notapreventivo'] = $_POST['notapreventivo'];

		$creaNotaVocePreventivo = new creaNotaVocePreventivo();
		if ($_GET['modo'] == "start") $creaNotaVocePreventivo->start();
		if ($_GET['modo'] == "go") $creaNotaVocePreventivo->go();
	}
	else {
		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>