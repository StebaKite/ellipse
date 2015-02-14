<?php

require_once 'preventivo.abstract.class.php';

class accettaPreventivo extends preventivoAbstract {

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

		/**
		 * Qui lega la cartella clinica al preventivo principale o al secondario
		 */
		if ($this->getIdPreventivo() != "") $idPreventivo = $this->getIdPreventivo(); 
		elseif ($this->getIdSottoPreventivo() != "") $idPreventivo = $this->getIdSottoPreventivo();
		
		if ($this->creaCartellaClinica($db, $idPreventivo, $this->getIdPaziente())) {

			$db->commitTransaction();

			$idCartellaClinicaUsato = $db->getLastIdUsed();

			/**
			 * Prelevo le voci del preventivo principale o secondario 
			 */
			if ($this->getIdPreventivo() != "") {
				$vociPreventivo = $this->prelevaVociPreventivo($db, $utility, $this->getIdPaziente(), $this->getIdPreventivo());
			}
			else {
				if ($this->getIdSottoPreventivo() != "")
					$vociPreventivo = $this->prelevaVociSottoPreventivo($db, $utility, $this->getIdPaziente(), $this->getIdPreventivoPrincipale(), $this->getIdSottoPreventivo());
			}
				
			$esito = TRUE;

			$db->beginTransaction();

			foreach ($vociPreventivo as $row) {

				if (!$this->creaVoceCartellaClinica($db, $idCartellaClinicaUsato, trim($row['nomeform']), trim($row['nomecampoform']), trim($row['codicevocelistino']), trim($row['prezzo']))) {
					$esito = FALSE;
					break;
				}
			}
			if (!$esito) {
				$db->rollbackTransaction();
				$ricercaPreventivo = new ricercaPreventivo();
				$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoKo%');
				$ricercaPreventivo->start();
			}
			else {

				/**
				 * Aggiorno lo stato del preventivo principale
				 */
				if ($this->getIdPreventivo() != "") {
					if ($this->aggiornaStatoPreventivo($db, $this->getIdPreventivo(), '01')) {

						/**
						 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
						 */
						$db->commitTransaction();
						$ricercaPreventivo = new ricercaPreventivo();
						$ricercaPreventivo->setIdPaziente($this->getIdPaziente());
						$ricercaPreventivo->setCognome($this->getCognome());
						$ricercaPreventivo->setNome($this->getNome());
						$ricercaPreventivo->setDataNascita($this->getDataNascita());
						$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoOk%');
						$ricercaPreventivo->start();
					}
					else {
						$db->rollbackTransaction();
						$ricercaPreventivo = new ricercaVisita();
						$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoKo%');
						$ricercaPreventivo->start();
					}
				}
				else {
					
					/**
					 * Aggiorno lo stato del preventivo secondario e del principale 
					 */
					
					if ($this->getIdSottoPreventivo() != "") {
						if ($this->aggiornaStatoSottoPreventivo($db, $this->getIdSottoPreventivo(), '01')) {
							
							/**
							 * Se non ci sono sottopreventivi in stato "Proposto" e l'importo del preventivo principale = 0
							 * aggiorno il preventivo principale in "Accettato"
							 */
							if (($this->leggiStatoPreventiviSecondari($db, $utility, $this->getIdPreventivoPrincipale(), $this->getIdPaziente(), '00') == 0)
							and ($this->leggiImportoPreventiviPrincipale($db, $utility, $this->getIdPreventivoPrincipale(), $this->getIdPaziente()) == 0)) {
								
								if ($this->aggiornaStatoPreventivo($db, $this->getIdPreventivoPrincipale(), '01')) {
									/**
									 * La funzione dovrà atterrare sulla ricerca della cartelle cliniche del paziente
									 */
									$db->commitTransaction();
									$ricercaPreventivo = new ricercaPreventivo();
									$ricercaPreventivo->setIdPaziente($this->getIdPaziente());
									$ricercaPreventivo->setCognome($this->getCognome());
									$ricercaPreventivo->setNome($this->getNome());
									$ricercaPreventivo->setDataNascita($this->getDataNascita());
									$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoOk%');
									$ricercaPreventivo->start();
								}
								else {
									$db->rollbackTransaction();
									$ricercaPreventivo = new ricercaVisita();
									$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoKo%');
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
									$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoOk%');
									$ricercaPreventivo->start();
								}
								else {
									$db->rollbackTransaction();
									$ricercaPreventivo = new ricercaVisita();
									$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoKo%');
									$ricercaPreventivo->start();
								}
							}
						}
						else {
							$db->rollbackTransaction();
							$ricercaPreventivo = new ricercaVisita();
							$ricercaPreventivo->setMessaggio('%ml.accettaPreventivoKo%');
							$ricercaPreventivo->start();
						}						
					}
				}				
			}
		}
		else {
			$db->rollbackTransaction();
			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->setMessaggio('%ml.accettaPreventivoKo%');
			$ricercaVisita->start();
		}
	}

	public function prelevaVociPreventivo($db, $utility, $idPaziente, $idPreventivo) {

		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo
		);

		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociPreventivoPrincipale;

		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);

		if ($result) return pg_fetch_all($result);
		else return "";
	}

	public function prelevaVociSottoPreventivo($db, $utility, $idPaziente, $idPreventivo, $idSottoPreventivo) {
	
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $idSottoPreventivo
		);
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociPreventivoSecondario;
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		if ($result) return pg_fetch_all($result);
		else return "";	}
	
}
	
?>