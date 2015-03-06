<?php

set_include_path('/var/www/html/ellipse/src/main:/var/www/html/ellipse/src/preventivo:/var/www/html/ellipse/src/visita:/var/www/html/ellipse/src/cartellaclinica:/var/www/html/ellipse/src/utility');
require_once 'accettaPreventivo.class.php';
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

$accettaPreventivo = new accettaPreventivo();
if ($_GET['modo'] == "start") $accettaPreventivo->start();
if ($_GET['modo'] == "go") $accettaPreventivo->go();

?>