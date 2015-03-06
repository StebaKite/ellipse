<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'includiVocePreventivo.class.php';
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

	$includiVocePreventivo = new includiVocePreventivo();
	if ($_GET['modo'] == "start") $includiVocePreventivo->start();
	if ($_GET['modo'] == "go") $includiVocePreventivo->go();
}
else {

	$firewall = new firewall();

	$data = array();	
	if ($_GET['idvocepreventivo'] != "") $data['idVocePreventivo'] = 'idVocePreventivo' . ';' . $_GET['idvocepreventivo'];
	if ($_GET['codicevocelistino'] != "") $data['codiceVoceListino'] = 'codiceVoceListino' . ';' . $_GET['codicevocelistino'];
	if ($_GET['prezzo'] != "") $data['prezzo'] = 'prezzo' . ';' . $_GET['prezzo'];
	if ($_GET['nomeform'] != "") $data['nomeForm'] = 'nomeForm' . ';' . $_GET['nomeform'];
	if ($_GET['nomecampoform'] != "") $data['nomeCampoForm'] = 'nomeCampoForm' . ';' . $_GET['nomecampoform'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idVocePreventivo'] = $_GET['idvocepreventivo'];
		$_SESSION['codicevocelistino'] = $_GET['codicevocelistino'];
		$_SESSION['prezzo'] = $_GET['prezzo'];
		$_SESSION['nomeform'] = $_GET['nomeform'];
		$_SESSION['nomecampoform'] = $_GET['nomecampoform'];

		$includiVocePreventivo = new includiVocePreventivo();
		if ($_GET['modo'] == "start") $includiVocePreventivo->start();
		if ($_GET['modo'] == "go") $includiVocePreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>