<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaNotaVocePreventivo.class.php';
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

		$modificaNotaVocePreventivo = new modificaNotaVocePreventivo();
		if ($_GET['modo'] == "start") $modificaNotaVocePreventivo->start();
		if ($_GET['modo'] == "go") $modificaNotaVocePreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idNotaVocePreventivo'] != "") $data['idNotaVocePreventivo'] = 'idNotaVocePreventivo' . ';' . $_GET['idNotaVocePreventivo'];
	
	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idNotaVocePreventivo'] = $_GET['idNotaVocePreventivo'];
		
		$modificaNotaVocePreventivo = new modificaNotaVocePreventivo();
		if ($_GET['modo'] == "start") $modificaNotaVocePreventivo->start();
		if ($_GET['modo'] == "go") $modificaNotaVocePreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>