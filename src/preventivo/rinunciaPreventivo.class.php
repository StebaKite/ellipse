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

		if ($this->getIdPreventivo() != "") $idPreventivo = $this->getIdPreventivo();
		elseif ($this->getIdSottoPreventivo() != "") $idPreventivo = $this->getIdSottoPreventivo();
		
		if ($this->rimuoviCartellaClinicaPreventivo($db, $utility, $idPreventivo, $this->getIdPaziente())) {
		
			/**
			 * Aggiorno lo stato del preventivo principale
			 */
			if ($this->getIdPreventivo() != "") {
				if ($this->aggiornaStatoPreventivo($db, $this->getIdPreventivo(), '00')) {
					/**
					 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
					 */
					$db->commitTransaction();
					$ricercaPreventivo = new ricercaPreventivo();
					$ricercaPreventivo->setIdPaziente($this->getIdPaziente());
					$ricercaPreventivo->setCognome($this->getCognome());
					$ricercaPreventivo->setNome($this->getNome());
					$ricercaPreventivo->setDataNascita($this->getDataNascita());
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
					
				if ($this->getIdSottoPreventivo() != "") {
					if ($this->aggiornaStatoSottoPreventivo($db, $this->getIdSottoPreventivo(), '00')) {

						/**
						 * Se non ci sono sottopreventivi in stato "Accettato"
						 * aggiorno il preventivo principale in "Proposto" altrimenti lo lascio nello stato in cui si trova 
						 */
						if ($this->leggiStatoPreventiviSecondari($db, $utility, $this->getIdPreventivoPrincipale(), $this->getIdPaziente(), '01') == 0) {
							if ($this->aggiornaStatoPreventivo($db, $this->getIdPreventivoPrincipale(), '00')) {
								/**
								 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
								 */
								$db->commitTransaction();
								$ricercaPreventivo = new ricercaPreventivo();
								$ricercaPreventivo->setIdPaziente($this->getIdPaziente());
								$ricercaPreventivo->setCognome($this->getCognome());
								$ricercaPreventivo->setNome($this->getNome());
								$ricercaPreventivo->setDataNascita($this->getDataNascita());
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
							if ($this->aggiornaStatoPreventivo($db, $this->getIdPreventivoPrincipale(), '02')) {
								/**
								 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
								 */
								$db->commitTransaction();
								$ricercaPreventivo = new ricercaPreventivo();
								$ricercaPreventivo->setIdPaziente($this->getIdPaziente());
								$ricercaPreventivo->setCognome($this->getCognome());
								$ricercaPreventivo->setNome($this->getNome());
								$ricercaPreventivo->setDataNascita($this->getDataNascita());
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