<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'modificaVocePreventivo.class.php';
require_once 'firewall.class.php';

/**
 * Avvio la sessione
 */
session_start();

/**
 * Controllo il secureCode in sessione
*/

if ($_SESSION[‘secureCode’] != ‘4406105963138001’) exit('Errore di sessione') ;

/**
 * Controllo dei parametri passati nella request
 */

if ($_POST['usa-sessione']) {

	/**
	 * Controllo i dati immessi in pagina
	 */
	$firewall = new firewall();
	
	$data = array();
	if ($_POST['descrizionevoce'] != "") $data['descrizionevoce'] = 'descrizionevoce' . ';' . $_POST['descrizionevoce'];
	if ($_POST['prezzo'] != "") $data['prezzo'] = 'prezzo' . ';' . $_POST['prezzo'];	
	
	if ($firewall->controlloCampiRichiesta($data)) {
	
		$_SESSION['descrizionevoce'] = $_POST['descrizionevoce'];
		$_SESSION['prezzo'] = $_POST['prezzo'];
	
		$modificaVocePreventivo = new modificaVocePreventivo();
		if ($_GET['modo'] == "start") $modificaVocePreventivo->start();
		if ($_GET['modo'] == "go") $modificaVocePreventivo->go();

	}
	else {
		echo 'ATTENZIONE! Parametro non corretto';
	}
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['tabella'] != "") $data['tabella'] = 'tabella' . ';' . $_GET['tabella'];
	if ($_GET['dente'] != "") $data['dente'] = 'dente' . ';' . $_GET['dente'];
	if ($_GET['idvocepreventivo'] != "") $data['idvocepreventivo'] = 'idvocepreventivo' . ';' . $_GET['idvocepreventivo'];
	if ($_GET['idvocesottopreventivo'] != "") $data['idvocesottopreventivo'] = 'idvocesottopreventivo' . ';' . $_GET['idvocesottopreventivo'];
	
	if ($firewall->controlloCampiRichiesta($data)) {
	
		$_SESSION['tabella'] = $_GET['tabella'];
		$_SESSION['dente'] = $_GET['dente'];
		$_SESSION['idVocePreventivo'] = $_GET['idvocepreventivo'];
		$_SESSION['idVoceSottoPreventivo'] = $_GET['idvocesottopreventivo'];
	
		$modificaVocePreventivo = new modificaVocePreventivo();
		if ($_GET['modo'] == "start") $modificaVocePreventivo->start();
		if ($_GET['modo'] == "go") $modificaVocePreventivo->go();
	}
	else {	
		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>