<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'creaPreventivo.cure.class.php';
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

	$creaPreventivoCure = new creaPreventivoCure();
	if ($_GET['modo'] == "start") $creaPreventivoCure->start();
	if ($_GET['modo'] == "go") $creaPreventivoCure->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idPreventivo'] != "") $data['idPreventivo'] = 'idPreventivo' . ';' . $_GET['idPreventivo'];
	if ($_GET['idPreventivoPrincipale'] != "") $data['idPreventivoPrincipale'] = 'idPreventivoPrincipale' . ';' . $_GET['idPreventivoPrincipale'];
	if ($_GET['idSottoPreventivo'] != "") $data['idSottoPreventivo'] = 'idSottoPreventivo' . ';' . $_GET['idSottoPreventivo'];
	if ($_GET['datainserimento'] != "") $data['dataInserimento'] = 'dataInserimento' . ';' . $_GET['datainserimento'];
	if ($_GET['stato'] != "") $data['stato'] = 'stato' . ';' . $_GET['stato'];


	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idPreventivo'] = $_GET['idPreventivo'];
		$_SESSION['idPreventivoPrincipale'] = $_GET['idPreventivoPrincipale'];
		$_SESSION['idSottoPreventivo'] = $_GET['idSottoPreventivo'];
		$_SESSION['dataInserimento'] = $_GET['datainserimento'];
		$_SESSION['stato'] = $_GET['stato'];

		$creaPreventivoCure = new creaPreventivoCure();
		if ($_GET['modo'] == "start") $creaPreventivoCure->start();
		if ($_GET['modo'] == "go") $creaPreventivoCure->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>