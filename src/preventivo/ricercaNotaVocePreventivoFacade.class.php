<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'ricercaNotaVocePreventivo.class.php';
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

	$ricercaNotaVocePreventivo = new ricercaNotaVocePreventivo();
	if ($_GET['modo'] == "start") $ricercaNotaVocePreventivo->start();
	if ($_GET['modo'] == "go") $ricercaNotaVocePreventivo->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idVocePreventivo'] != "") $data['idVocePreventivo'] = 'idVocePreventivo' . ';' . $_GET['idVocePreventivo'];
	if ($_GET['idVoceSottoPreventivo'] != "") $data['idVoceSottoPreventivo'] = 'idVoceSottoPreventivo' . ';' . $_GET['idVoceSottoPreventivo'];
	
	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idVocePreventivo'] = $_GET['idVocePreventivo'];
		$_SESSION['idVoceSottoPreventivo'] = $_GET['idVoceSottoPreventivo'];
		
		$ricercaNotaVocePreventivo = new ricercaNotaVocePreventivo();
		if ($_GET['modo'] == "start") $ricercaNotaVocePreventivo->start();
		if ($_GET['modo'] == "go") $ricercaNotaVocePreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>