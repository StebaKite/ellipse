<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/impostazioni:/var/www/html/ellipse/src/utility');
require_once 'ricercaPaziente.class.php';
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
	
	$ricercaPaziente = new ricercaPaziente();
	if ($_GET["modo"] == "start") $ricercaPaziente->start();
	if ($_GET["modo"] == "go") $ricercaPaziente->go();
	
}
else {

	$firewall = new firewall();
	
	$data = array();
	if ($_POST['cognome'] != "") $data['campo'] = 'cognome' . ';' . $_POST['cognome'];
	
	if ($firewall->controlloCampiRichiesta($data)) {
	
		$_SESSION['cognome'] = trim($_POST['cognome']);
		$_SESSION['modificatioggi'] = $_POST['modificatioggi'];
		$_SESSION['proposte'] = $_POST['proposte'];
		
		$ricercaPaziente = new ricercaPaziente();
		if ($_GET["modo"] == "start") $ricercaPaziente->start();
		if ($_GET["modo"] == "go") $ricercaPaziente->go();
	}
	else {
		$ricercaPaziente = new ricercaPaziente();
		$ricercaPaziente->start();
	}	
}

?>
