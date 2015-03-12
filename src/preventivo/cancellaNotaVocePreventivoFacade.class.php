<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'cancellaNotaVocePreventivo.class.php';
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

	$cancellaNotaVocePreventivo = new cancellaNotaVocePreventivo();
	if ($_GET['modo'] == "start") $cancellaNotaVocePreventivo->start();
	if ($_GET['modo'] == "go") $cancellaNotaVocePreventivo->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idNotaVocePreventivo'] != "") $data['idNotaVocePreventivo'] = 'idNotaVocePreventivo' . ';' . $_GET['idNotaVocePreventivo'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idNotaVocePreventivo'] = $_GET['idNotaVocePreventivo'];

		$cancellaNotaVocePreventivo = new cancellaNotaVocePreventivo();
		if ($_GET['modo'] == "start") $cancellaNotaVocePreventivo->start();
		if ($_GET['modo'] == "go") $cancellaNotaVocePreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>