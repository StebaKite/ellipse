<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/paziente:/var/www/html/ellipse/src/strumenti:/var/www/html/ellipse/src/utility');
require_once 'creaVisita.class.php';
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

	$creaVisita = new creaVisita();
	if ($_GET['modo'] == "start") $creaVisita->start();
	if ($_GET['modo'] == "go") $creaVisita->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['cognRic'] != "") $data['cognRic'] = 'cognRic' . ';' . $_GET['cognRic'];
	if ($_GET['cognome'] != "") $data['cognome'] = 'cognome' . ';' . $_GET['cognome'];
	if ($_GET['nome'] != "") $data['nome'] = 'nome' . ';' . $_GET['nome'];
	if ($_GET['idListino'] != "") $data['idListino'] = 'idListino' . ';' . $_GET['idListino'];
	if ($_GET['idPaziente'] != "") $data['idPaziente'] = 'idPaziente' . ';' . $_GET['idPaziente'];
	if ($_GET['datanascita'] != "") $data['datanascita'] = 'datanascita' . ';' . $_GET['datanascita'];

	if ($_GET['idVisita'] != "") $data['idVisita'] = 'idVisita' . ';' . $_GET['idVisita'];
	if ($_GET['datainserimento'] != "") $data['dataInserimento'] = 'dataInserimento' . ';' . $_GET['datainserimento'];
	if ($_GET['stato'] != "") $data['statoVisita'] = 'statoVisita' . ';' . $_GET['stato'];

	if ($firewall->controlloCampiRichiesta($data)) {

		$_SESSION['cognRic'] = trim($_GET['cognRic']);
		$_SESSION['cognome'] = trim($_GET['cognome']);
		$_SESSION['nome'] = trim($_GET['nome']);
		$_SESSION['idListino'] = trim($_GET['idListino']);
		$_SESSION['idPaziente'] = trim($_GET['idPaziente']);
		$_SESSION['datanascita'] = trim($_GET['datanascita']);
		
		$_SESSION['idVisita'] = trim($_GET['idVisita']);
		$_SESSION['datainserimentovisita'] = trim($_GET['datainserimento']);
		$_SESSION['statovisita'] = trim($_GET['stato']);

		$creaVisita = new creaVisita();
		if ($_GET['modo'] == "start") $creaVisita->start();
		if ($_GET['modo'] == "go") $creaVisita->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>
