<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/cartellaclinica:/var/www/html/ellipse/src/utility');
require_once 'rinunciaPreventivo.class.php';
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
 * La funzione trova tutti i dati in sessione
*/

$rinunciaPreventivo = new rinunciaPreventivo();
if ($_GET['modo'] == "start") $rinunciaPreventivo->start();
if ($_GET['modo'] == "go") $rinunciaPreventivo->go();

?>