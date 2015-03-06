<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.gruppi.class.php';
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

	$creaVisitaGruppi = new creaVisitaGruppi();
	if ($_GET['modo'] == "start") $creaVisitaGruppi->start();
	if ($_GET['modo'] == "go") $creaVisitaGruppi->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['idVisita'] != "") $data['idVisita'] = 'idVisita' . ';' . $_GET['idVisita'];
	if ($_GET['datainserimento'] != "") $data['dataInserimento'] = 'dataInserimento' . ';' . $_GET['datainserimento'];
	if ($_GET['stato'] != "") $data['statoVisita'] = 'statoVisita' . ';' . $_GET['stato'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['idVisita'] = trim($_GET['idVisita']);
		$_SESSION['datainserimentovisita'] = trim($_GET['datainserimento']);
		$_SESSION['statovisita'] = trim($_GET['stato']);

		$creaVisitaGruppi = new creaVisitaGruppi();
		if ($_GET['modo'] == "start") $creaVisitaGruppi->start();
		if ($_GET['modo'] == "go") $creaVisitaGruppi->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>
