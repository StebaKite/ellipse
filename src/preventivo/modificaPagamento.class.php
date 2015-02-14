<?php

require_once 'preventivo.abstract.class.php';

class modificaPagamento extends preventivoAbstract {

	public static $azioneDentiSingoli = "../preventivo/modificaPreventivoFacade.class.php?modo=start";
	public static $azioneGruppi = "../preventivo/modificaPreventivoGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../preventivo/modificaPreventivoCureFacade.class.php?modo=start";
	public static $azionePagamento = "../preventivo/modificaPagamentoFacade.class.php?modo=go";

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];

		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
	}

	public function getSingoliForm() {
		return self::$singoliForm;
	}

	// ------------------------------------------------

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'database.class.php';
		require_once 'pagamento.template.php';
		require_once 'utility.class.php';

		$utility = new utility();
		$db = new database();

		$db->beginTransaction();
		
		$pagamentoTemplate = new pagamentoTemplate();
		$this->preparaPagina($db, $utility, $pagamentoTemplate);

		$db->commitTransaction();
		
		// Compone la pagina
		include(self::$testata);
		$pagamentoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'database.class.php';
		require_once 'pagamento.template.php';
		require_once 'utility.class.php';

		$db = new database();
		$utility = new utility();

		$db->beginTransaction();
		
		$pagamentoTemplate = new pagamentoTemplate();
		$this->preparaPagina($db, $utility, $pagamentoTemplate);
		/**
		 * Salvo i valori originali prelevati da db
		 */
		$importoDaRateizzare_db =  $this->getImportoDaRateizzare();
		$dataPrimaRata_db = $this->getDataPrimaRata();
		$numeroGiorniRata_db = $this->getNumeroGiorniRata();
		$importoRata_db = $this->getImportoRata();
		
		/**
		 * Salvo i valori impostati sl form
		 */
		$this->prelevaCampiFormPagamento();
		$importoDaRateizzare_form = $this->getImportoDaRateizzare();
		$dataPrimaRata_form = $this->getDataPrimaRata();
		$numeroGiorniRata_form = $this->getNumeroGiorniRata();
		$importoRata_form = $this->getImportoRata();
		
		include(self::$testata);
		
		if ($pagamentoTemplate->controlliLogici()) {
		
			if ($this->modifica($db, $utility, $pagamentoTemplate)) {

				/**
				 * Se è stato variato un parametro per la rateizzazione dell'importo cancello tutte le rate del preventivo e le rigenero 
				 */
				if (($importoDaRateizzare_db != $importoDaRateizzare_form)
				or ($dataPrimaRata_db != $dataPrimaRata_form)
				or ($numeroGiorniRata_db != $numeroGiorniRata_form)
				or ($importoRata_db != $importoRata_form)) {
					
					if (($this->cancellaRatePagamentoPreventivo($db, $utility))
					and ($this->generaRatePagamentoPreventivo($db, $utility, $this->getImportoDaRateizzare(), $this->getDataPrimaRata(), $this->getNumeroGiorniRata(), $this->getImportoRata()))) {
						
						$this->leggiRatePagamentoPreventivo($db, $utility);
						
						$pagamentoTemplate->displayPagina();
						$replace = array('%messaggio%' => '%ml.modPagamentoOk%');
						$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
						echo $utility->tailTemplate($template);
						$db->commitTransaction();
					}
					else {
						$pagamentoTemplate->displayPagina();
						$replace = array('%messaggio%' => '%ml.modPagamentoKo%');
						$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
						echo $utility->tailTemplate($template);
						$db->rollbackTransaction();
					}
				}
				else {					
					$pagamentoTemplate->displayPagina();
					$replace = array('%messaggio%' => '%ml.modPagamentoOk%');
					$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
					echo $utility->tailTemplate($template);
				}
			}
			else {
				$pagamentoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modPagamentoKo%');		
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);		
			}
		}
		else {
			$pagamentoTemplate->displayPagina();
		}
		include(self::$piede);
	}

	public function preparaPagina($db, $utility, $pagamentoTemplate) {
	
		$pagamentoTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$pagamentoTemplate->setAzioneGruppi(self::$azioneGruppi);
		$pagamentoTemplate->setAzioneCure(self::$azioneCure);
		$pagamentoTemplate->setAzionePagamento(self::$azionePagamento);
	
		if ($this->getIdPreventivo() != "") {
			$pagamentoTemplate->setTitoloPagina("%ml.modificaPagamentoPrincipaleDentiSingoli%");
			$this->leggiCondizioniPagamentoPreventivoPrincipale($db, $utility, $this->getIdPreventivo());
			$this->setRatePagamento($this->leggiRatePagamentoPreventivoPrincipale($db, $utility, $this->getIdPreventivo()));				
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$pagamentoTemplate->setTitoloPagina("%ml.modificaPagamentoSecondarioDentiSingoli%");
			$this->leggiCondizioniPagamentoPreventivoSecondario($db, $utility, $this->getIdSottoPreventivo());
			$this->setRatePagamento($this->leggiRatePagamentoPreventivoSecondario($db, $utility, $this->getIdSottoPreventivo()));				
		}
	
		$pagamentoTemplate->setPreventivoLabel("Preventivo");
	}	
	
	private function modifica($db, $utility, $pagamentoTemplate) {

		if ($this->getIdPreventivo() != "") {
			if ($this->modificaPreventivoPrincipale($db, $utility, $this->getIdPreventivo(), $pagamentoTemplate)) return TRUE;
			else return FALSE; 
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			if ($this->modificaPreventivoSecondario($db, $utility, $this->getIdSottoPreventivo(), $pagamentoTemplate)) return TRUE;
			else return FALSE;
		}		
	}
	
	private function modificaPreventivoPrincipale($db, $utility, $idPreventivo, $pagamentoTemplate) {

		$array = $utility->getConfig();
	
		if ($pagamentoTemplate->getScontoPercentuale() == "") $scontoPercentuale = 'null';
		else $scontoPercentuale = $pagamentoTemplate->getScontoPercentuale();

		if ($pagamentoTemplate->getScontoContante() == "") $scontoContante = 'null';
		else $scontoContante = $pagamentoTemplate->getScontoContante();

		if ($pagamentoTemplate->getAccontoInizioCura() == "") $accontoInizioCura = 'null';
		else $accontoInizioCura = $pagamentoTemplate->getAccontoInizioCura();

		if ($pagamentoTemplate->getAccontoMetaCura() == "") $accontoMetaCura = 'null';
		else $accontoMetaCura = $pagamentoTemplate->getAccontoMetaCura();

		if ($pagamentoTemplate->getSaldoFineCura() == "") $saldoFineCura = 'null';
		else $saldoFineCura = $pagamentoTemplate->getSaldoFineCura();

		if ($pagamentoTemplate->getNumeroGiorniRata() == "") $numeroGiorniRata = 'null';
		else $numeroGiorniRata = $pagamentoTemplate->getNumeroGiorniRata();

		if ($pagamentoTemplate->getImportoRata() == "") $importoRata = 'null';
		else $importoRata = $pagamentoTemplate->getImportoRata();

		if ($pagamentoTemplate->getImportoDaRateizzare() == "") $importoDaRateizzare = 'null';
		else $importoDaRateizzare = $pagamentoTemplate->getImportoDaRateizzare();

		if ($pagamentoTemplate->getDataPrimaRata() == "") $dataPrimaRata = 'null';
		else $dataPrimaRata = "'" . $pagamentoTemplate->getDataPrimaRata() . "'";
		
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%scontopercentuale%' => $scontoPercentuale,
				'%scontocontante%' => $scontoContante,
				'%accontoiniziocura%' => $accontoInizioCura,
				'%accontometacura%' => $accontoMetaCura,
				'%saldofinecura%' => $saldoFineCura,
				'%numerogiornirata%' => $numeroGiorniRata,
				'%importorata%' => $importoRata,
				'%importodarateizzare%' => $importoDaRateizzare,
				'%dataprimarata%' => $dataPrimaRata		
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaPagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);	
		$result = $db->execSql($sql);

		return $result;
	}	

	private function modificaPreventivoSecondario($db, $utility, $idSottoPreventivo, $pagamentoTemplate) {

		$array = $utility->getConfig();
	
		if ($pagamentoTemplate->getScontoPercentuale() == "") $scontoPercentuale = 'null';
		else $scontoPercentuale = $pagamentoTemplate->getScontoPercentuale();

		if ($pagamentoTemplate->getScontoContante() == "") $scontoContante = 'null';
		else $scontoContante = $pagamentoTemplate->getScontoContante();

		if ($pagamentoTemplate->getAccontoInizioCura() == "") $accontoInizioCura = 'null';
		else $accontoInizioCura = $pagamentoTemplate->getAccontoInizioCura();

		if ($pagamentoTemplate->getAccontoMetaCura() == "") $accontoMetaCura = 'null';
		else $accontoMetaCura = $pagamentoTemplate->getAccontoMetaCura();

		if ($pagamentoTemplate->getSaldoFineCura() == "") $saldoFineCura = 'null';
		else $saldoFineCura = $pagamentoTemplate->getSaldoFineCura();

		if ($pagamentoTemplate->getNumeroGiorniRata() == "") $numeroGiorniRata = 'null';
		else $numeroGiorniRata = $pagamentoTemplate->getNumeroGiorniRata();

		if ($pagamentoTemplate->getImportoRata() == "") $importoRata = 'null';
		else $importoRata = $pagamentoTemplate->getImportoRata();

		if ($pagamentoTemplate->getImportoDaRateizzare() == "") $importoDaRateizzare = 'null';
		else $importoDaRateizzare = $pagamentoTemplate->getImportoDaRateizzare();

		if ($pagamentoTemplate->getDataPrimaRata() == "") $dataPrimaRata = 'null';
		else $dataPrimaRata = "'" . $pagamentoTemplate->getDataPrimaRata() . "'";
		
		$replace = array(
				'%idsottopreventivo%' => $idSottoPreventivo,
				'%scontopercentuale%' => $scontoPercentuale,
				'%scontocontante%' => $scontoContante,
				'%accontoiniziocura%' => $accontoInizioCura,
				'%accontometacura%' => $accontoMetaCura,
				'%saldofinecura%' => $saldoFineCura,
				'%numerogiornirata%' => $numeroGiorniRata,
				'%importorata%' => $importoRata,
				'%importodarateizzare%' => $importoDaRateizzare,
				'%dataprimarata%' => $dataPrimaRata		
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaPagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);	
		$result = $db->execSql($sql);

		return $result;
	}

	public function cancellaRatePagamentoPreventivo($db, $utility) {

		if ($this->getIdPreventivo() != "") {
			if ($this->cancellaRatePagamentoPreventivoPrincipale($db, $utility, $this->getIdPreventivo())) return TRUE;
			else return FALSE;
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			if ($this->cancellaRatePagamentoPreventivoSecondario($db, $utility, $this->getIdSottoPreventivo())) return TRUE;
			else return FALSE;
		}		
	}

	public function leggiRatePagamentoPreventivo($db, $utility) {

		if ($this->getIdPreventivo() != "") {
			$this->setRatePagamento($this->leggiRatePagamentoPreventivoPrincipale($db, $utility, $this->getIdPreventivo()));
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$this->setRatePagamento($this->leggiRatePagamentoPreventivoSecondario($db, $utility, $this->getIdSottoPreventivo()));
		}
	}	
	
	public function generaRatePagamentoPreventivo($db, $utility, $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata) {
		
		if ($this->getIdPreventivo() != "") {
			if ($this->generaRatePagamentoPreventivoPrincipale($db, $utility, $this->getIdPreventivo(), $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata)) return TRUE;
			else return FALSE;
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			if ($this->generaRatePagamentoPreventivoSecondario($db, $utility, $this->getIdSottoPreventivo(), $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata)) return TRUE;
			else return FALSE;
		}		
	}		
	
	public function generaRatePagamentoPreventivoPrincipale($db, $utility, $idPreventivo, $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata) {

		/**
		 * Se l'importo da rateizzare passato è vuoto non genero le rate e restituisco ok
		 */

		if ($importoDaRateizzare != "") {

			$dataScadenza = $dataPrimaRata;
			
			/**
			 * Creo la prima rata
			 */
			$this->creaRataPagamentoPreventivoPrincipale($db, $utility, $idPreventivo, $dataScadenza, $importoRata, '00');
			
			if($importoDaRateizzare >= $importoRata) {
					
				$importo = $importoDaRateizzare - $importoRata;
				do {
					$data = $this->sommaGiorniData($dataScadenza, "/", $numeroGiorniRata);
					if ($importo >= $importoRata) {
						$this->creaRataPagamentoPreventivoPrincipale($db, $utility, $idPreventivo, $data, $importoRata, '00');
					}
					else {
						$this->creaRataPagamentoPreventivoPrincipale($db, $utility, $idPreventivo, $data, $importo, '00');
						$importo = 0;
					}
					$importo -= $importoRata;
					$dataScadenza = $data;
						
				} while ($importo > 0);
			
			}
			else {
				$importo = 0;
			}
			
			if ($importo <= 0) return TRUE;
			else return FALSE;
				
		}
		else return TRUE;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $importoDaRateizzare
	 * @param unknown $dataPrimaRata
	 * @param unknown $numeroGiorniRata
	 * @param unknown $importoRata
	 * @return L'esito della creazione True/False
	 */
	public function generaRatePagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo, $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata) {
	
		/**
		 * Se l'importo da rateizzare passato è vuoto non genero le rate e restituisco ok
		 */
	
		if ($importoDaRateizzare != "") {
	
			$dataScadenza = $dataPrimaRata;
				
			/**
			 * Creo la prima rata
			 */
			$this->creaRataPagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo, $dataScadenza, $importoRata, '00');
				
			if($importoDaRateizzare >= $importoRata) {
					
				$importo = $importoDaRateizzare - $importoRata;
				do {
					$data = $this->sommaGiorniData($dataScadenza, "/", $numeroGiorniRata);
					if ($importo >= $importoRata) {
						$this->creaRataPagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo, $data, $importoRata, '00');
					}
					else {
						$this->creaRataPagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo, $data, $importo, '00');
						$importo = 0;
					}
					$importo -= $importoRata;
					$dataScadenza = $data;
	
				} while ($importo > 0);
					
			}
			else {
				$importo = 0;
			}
				
			if ($importo <= 0) return TRUE;
			else return FALSE;
	
		}
		else return TRUE;
	}
}	
	
?>