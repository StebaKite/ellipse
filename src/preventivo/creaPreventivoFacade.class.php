<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/utility');
require_once 'creaPreventivo.class.php';
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

	$creaPreventivo = new creaPreventivo();
	if ($_GET['modo'] == "start") $creaPreventivo->start();
	if ($_GET['modo'] == "go") $creaPreventivo->go();
}
else {

	$firewall = new firewall();

	$data = array();
	if ($_GET['cognome'] != "") $data['cognome'] = 'cognome' . ';' . $_GET['cognome'];
	if ($_GET['nome'] != "") $data['nome'] = 'nome' . ';' . $_GET['nome'];
	if ($_GET['idListino'] != "") $data['idListino'] = 'idListino' . ';' . $_GET['idListino'];
	if ($_GET['idPaziente'] != "") $data['idPaziente'] = 'idPaziente' . ';' . $_GET['idPaziente'];
	if ($_GET['datanascita'] != "") $data['datanascita'] = 'datanascita' . ';' . $_GET['datanascita'];
	
	if ($_GET['idPreventivo'] != "") $data['idPreventivo'] = 'idPreventivo' . ';' . $_GET['idPreventivo'];
	if ($_GET['idPreventivoPrincipale'] != "") $data['idPreventivoPrincipale'] = 'idPreventivoPrincipale' . ';' . $_GET['idPreventivoPrincipale'];
	if ($_GET['idSottoPreventivo'] != "") $data['idSottoPreventivo'] = 'idSottoPreventivo' . ';' . $_GET['idSottoPreventivo'];
	if ($_GET['datainserimento'] != "") $data['dataInserimento'] = 'dataInserimento' . ';' . $_GET['datainserimento'];
	if ($_GET['stato'] != "") $data['stato'] = 'stato' . ';' . $_GET['stato'];


	if ($firewall->controlloCampiRichiesta($data)) {
		
		$_SESSION['cognome'] = trim($_GET['cognome']);
		$_SESSION['nome'] = trim($_GET['nome']);
		$_SESSION['idListino'] = trim($_GET['idListino']);
		$_SESSION['idPaziente'] = trim($_GET['idPaziente']);
		$_SESSION['datanascita'] = trim($_GET['datanascita']);
		
		$_SESSION['idPreventivo'] = $_GET['idPreventivo'];
		$_SESSION['idPreventivoPrincipale'] = $_GET['idPreventivoPrincipale'];
		$_SESSION['idSottoPreventivo'] = $_GET['idSottoPreventivo'];
		$_SESSION['dataInserimento'] = $_GET['datainserimento'];
		$_SESSION['stato'] = $_GET['stato'];

		$creaPreventivo = new creaPreventivo();
		if ($_GET['modo'] == "start") $creaPreventivo->start();
		if ($_GET['modo'] == "go") $creaPreventivo->go();
	}
	else {

		echo 'ATTENZIONE! Parametro non corretto';
	}
}

?>