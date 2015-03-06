<?php

require_once 'preventivo.abstract.class.php';

class rinunciaPreventivo extends preventivoAbstract {

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// ------------------------------------------------

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'ricercaPreventivo.class.php';
//		require_once 'ricercaCartellaClinica.class.php';
		require_once 'database.class.php';
		require_once 'utility.class.php';

		$db = new database();
		$utility = new utility();

		$db->beginTransaction();

		if ($_SESSION['idPreventivo'] != "") $idPreventivo = $_SESSION['idPreventivo'];
		elseif ($_SESSION['idSottoPreventivo'] != "") $idPreventivo = $_SESSION['idSottoPreventivo'];
		
		if ($this->rimuoviCartellaClinicaPreventivo($db, $utility, $idPreventivo, $_SESSION['idPaziente'])) {
		
			/**
			 * Aggiorno lo stato del preventivo principale
			 */
			if ($_SESSION['idPreventivo'] != "") {
				if ($this->aggiornaStatoPreventivo($db, $_SESSION['idPreventivo'], '00')) {
					/**
					 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
					 */
					$db->commitTransaction();
					$ricercaPreventivo = new ricercaPreventivo();
					$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoOk%');
					$ricercaPreventivo->start();
				}
				else {
					$db->rollbackTransaction();
					$ricercaPreventivo = new ricercaVisita();
					$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoKo%');
					$ricercaPreventivo->start();
				}
			}
			else {
				/**
				 * Aggiorno lo stato del preventivo secondario e del principale
				 */
					
				if ($_SESSION['idSottoPreventivo'] != "") {
					if ($this->aggiornaStatoSottoPreventivo($db, $_SESSION['idSottoPreventivo'], '00')) {

						/**
						 * Se non ci sono sottopreventivi in stato "Accettato"
						 * aggiorno il preventivo principale in "Proposto" altrimenti lo lascio nello stato in cui si trova 
						 */
						if ($this->leggiStatoPreventiviSecondari($db, $utility, $_SESSION['idPreventivoPrincipale'], $_SESSION['idPaziente'], '01') == 0) {
							if ($this->aggiornaStatoPreventivo($db, $_SESSION['idPreventivoPrincipale'], '00')) {
								/**
								 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
								 */
								$db->commitTransaction();
								$ricercaPreventivo = new ricercaPreventivo();
								$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoOk%');
								$ricercaPreventivo->start();
							}
							else {
								$db->rollbackTransaction();
								$ricercaPreventivo = new ricercaVisita();
								$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoKo%');
								$ricercaPreventivo->start();
							}
						}
						else {
							if ($this->aggiornaStatoPreventivo($db, $_SESSION['idPreventivoPrincipale'], '02')) {
								/**
								 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
								 */
								$db->commitTransaction();
								$ricercaPreventivo = new ricercaPreventivo();
								$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoOk%');
								$ricercaPreventivo->start();								
							}
							else {
								$db->rollbackTransaction();
								$ricercaPreventivo = new ricercaVisita();
								$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoKo%');
								$ricercaPreventivo->start();								
							}
						}					
					}
					else {
						$db->rollbackTransaction();
						$ricercaPreventivo = new ricercaVisita();
						$ricercaPreventivo->setMessaggio('%ml.rinunciaPreventivoKo%');
						$ricercaPreventivo->start();						
					}
				}
			}
		}
	}
}		
		
?>