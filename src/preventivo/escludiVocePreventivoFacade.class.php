<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'escludiVocePreventivo.class.php';
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

	$escludiVocePreventivo = new escludiVocePreventivo();
	if ($_GET['modo'] == "start") $escludiVocePreventivo->start();
	if ($_GET['modo'] == "go") $escludiVocePreventivo->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idvocesottopreventivo'] != "") $data['idVoceSottoPreventivo'] = 'idVoceSottoPreventivo' . ';' . $_GET['idvocesottopreventivo'];
	if ($_GET['codicevocelistino'] != "") $data['codiceVoceListino'] = 'codiceVoceListino' . ';' . $_GET['codicevocelistino'];
	if ($_GET['prezzo'] != "") $data['prezzo'] = 'prezzo' . ';' . $_GET['prezzo'];
	if ($_GET['nomeform'] != "") $data['nomeForm'] = 'nomeForm' . ';' . $_GET['nomeform'];
	if ($_GET['nomecampoform'] != "") $data['nomeCampoForm'] = 'nomeCampoForm' . ';' . $_GET['nomecampoform'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idVoceSottoPreventivo'] = $_GET['idvocesottopreventivo'];
		$_SESSION['codicevocelistino'] = $_GET['codicevocelistino'];
		$_SESSION['prezzo'] = $_GET['prezzo'];
		$_SESSION['nomeform'] = $_GET['nomeform'];
		$_SESSION['nomecampoform'] = $_GET['nomecampoform'];

		$escludiVocePreventivo = new escludiVocePreventivo();
		if ($_GET['modo'] == "start") $escludiVocePreventivo->start();
		if ($_GET['modo'] == "go") $escludiVocePreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>