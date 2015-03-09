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
		$scontoPercentuale_db = $_SESSION['scontopercentuale'];
		$scontoContante_db = $_SESSION['scontocontante'];
		$importoDaRateizzare_db =  $_SESSION['importodarateizzare'];
		$dataPrimaRata_db = $_SESSION['dataprimarata'];
		$numeroGiorniRata_db = $_SESSION['numerogiornirata'];
		$importoRata_db = $_SESSION['importorata'];
		
		/**
		 * Salvo i valori impostati sl form
		 */
		$this->prelevaCampiFormPagamento();
		$scontoPercentuale_form = $_SESSION['scontopercentuale'];
		$scontoContante_form = $_SESSION['scontocontante'];
		$importoDaRateizzare_form = $_SESSION['importodarateizzare'];
		$dataPrimaRata_form = $_SESSION['dataprimarata'];
		$numeroGiorniRata_form = $_SESSION['numerogiornirata'];
		$importoRata_form = $_SESSION['importorata'];
		
		include(self::$testata);
		
		if ($pagamentoTemplate->controlliLogici($scontoPercentuale_db, $scontoContante_db, $importoDaRateizzare_db, $dataPrimaRata_db, $numeroGiorniRata_db, $importoRata_db, 
												$scontoPercentuale_form, $scontoContante_form, $importoDaRateizzare_form, $dataPrimaRata_form, $numeroGiorniRata_form, $importoRata_form)) {
			
			if ($this->modifica($db, $utility, $pagamentoTemplate)) {

				/**
				 * Se è stata inserito una data scadenza acconto lo aggiungo in tabella 
				 */
				if ($_SESSION['datascadenzaacconto'] != "") {
					if (!$this->creaAccontoPreventivo($db, $utility, $_SESSION['datascadenzaacconto'], $_SESSION['descrizioneacconto'], $_SESSION['importoacconto'])) {
						
						$pagamentoTemplate->displayPagina();
						$replace = array('%messaggio%' => '%ml.modPagamentoKo%');
						$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
						echo $utility->tailTemplate($template);
						$db->rollbackTransaction();
					}
				}

				$_SESSION['datascadenzaacconto'] = "";
				$_SESSION['descrizioneacconto'] = "";
				$_SESSION['importoacconto'] = "";
				
				$this->leggiAccontiPreventivo($db, $utility);
								
				/**
				 * Se è stato variato un parametro per la rateizzazione dell'importo cancello tutte le rate del preventivo e le rigenero 
				 */
				if (($importoDaRateizzare_db != $importoDaRateizzare_form)
				or ($dataPrimaRata_db != $dataPrimaRata_form)
				or ($numeroGiorniRata_db != $numeroGiorniRata_form)
				or ($importoRata_db != $importoRata_form)) {
					
					if (($this->cancellaRatePagamentoPreventivo($db, $utility))
					and ($this->generaRatePagamentoPreventivo($db, $utility, $_SESSION['importodarateizzare'], $_SESSION['dataprimarata'], $_SESSION['numerogiornirata'], $_SESSION['importorata']))) {
						
						$this->leggiRatePagamentoPreventivo($db, $utility);
						$this->preparaPagina($db, $utility, $pagamentoTemplate);
						
						$pagamentoTemplate->displayPagina();
						$replace = array('%messaggio%' => '%ml.rateok%' . ' - ' . '%ml.modPagamentoOk%');
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
					$this->preparaPagina($db, $utility, $pagamentoTemplate);
					$pagamentoTemplate->displayPagina();
					$replace = array('%messaggio%' => '%ml.modPagamentoOk%');
					$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
					echo $utility->tailTemplate($template);
					$db->commitTransaction();
				}
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
		}		
		include(self::$piede);
	}

	public function preparaPagina($db, $utility, $pagamentoTemplate) {
	
		$pagamentoTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$pagamentoTemplate->setAzioneGruppi(self::$azioneGruppi);
		$pagamentoTemplate->setAzioneCure(self::$azioneCure);
		$pagamentoTemplate->setAzionePagamento(self::$azionePagamento);
	
		if ($_SESSION['idPreventivo'] != "") {
			$pagamentoTemplate->setTitoloPagina("%ml.modificaPagamentoPrincipaleDentiSingoli%");
			$this->leggiCondizioniPagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
			$_SESSION['ratepagamento'] = $this->leggiRatePagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
			$_SESSION['acconti'] = $this->leggiAccontiPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
			$vociPagateInPiano = $this->sommaImportoVociPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo'], '01');
			$vociDaPagareInPiano = $this->sommaImportoVociPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo'], '00');
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$pagamentoTemplate->setTitoloPagina("%ml.modificaPagamentoSecondarioDentiSingoli%");
			$this->leggiCondizioniPagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
			$_SESSION['ratepagamento'] = $this->leggiRatePagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
			$_SESSION['acconti'] = $this->leggiAccontiPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
			$vociPagateInPiano = $this->sommaImportoVociPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo'], '01');
			$vociDaPagareInPiano = $this->sommaImportoVociPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo'], '00');
		}

		/**
		 * Determino la situazione del preventivo
		 */
			
		foreach ($vociPagateInPiano as $row) {
			$totalePagatoInPiano += $row['totale'];
		}
		$_SESSION['totalepagatoinpiano'] = $totalePagatoInPiano;
						
		foreach ($vociDaPagareInPiano as $row) {
			$totaleDaPagareInPiano += $row['totale'];
		}
		$_SESSION['totaledapagareinpiano'] = $totaleDaPagareInPiano;
		
		$_SESSION['totalepreventivo'] = $this->calcolaTotalePreventivo($db);

		/**
		 * Ricalcolo l'importo o la percentuale di sconto sul totale del preventivo, se il totale cambia a causa dell'inserimento di
		 * nuove voci, lo sconto viene ricalcolato ed il fuori piano adeguato di conseguenza
		 */
		if ($_SESSION['scontopercentuale'] > 0) {
			$_SESSION['scontocontante'] = ($_SESSION['totalepreventivo'] / 100) * $_SESSION['scontopercentuale'];			// calcolo il contante da sommare al residuo fuori piano
		}		
		
		$_SESSION['totaledapagarefuoripiano'] = $_SESSION['totalepreventivo'] - $_SESSION['totaledapagareinpiano'] - $_SESSION['totalepagatoinpiano'] - $_SESSION['scontocontante'];				
					
		unset($_SESSION['datascadenzaacconto']);
		unset($_SESSION['descrizioneacconto']);
		unset($_SESSION['importoacconto']);
		$pagamentoTemplate->setPreventivoLabel("Preventivo");
		$pagamentoTemplate->setTotalePreventivoLabel("Totale:");
		$pagamentoTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
	}	
	
	private function creaAccontoPreventivo($db, $utility, $dataScadenzaAcconto, $descrizioneAcconto, $importoAcconto) {

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->creaAccontoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo'], $dataScadenzaAcconto, $descrizioneAcconto, $importoAcconto)) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->creaAccontoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo'], $dataScadenzaAcconto, $descrizioneAcconto, $importoAcconto)) return TRUE;
			else return FALSE;
		}		
	}
	
	
	private function modifica($db, $utility, $pagamentoTemplate) {

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->modificaPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo'], $pagamentoTemplate)) return TRUE;
			else return FALSE; 
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->modificaPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo'], $pagamentoTemplate)) return TRUE;
			else return FALSE;
		}		
	}
	
	private function modificaPreventivoPrincipale($db, $utility, $idPreventivo, $pagamentoTemplate) {

		$array = $utility->getConfig();
	
		if ($_SESSION['scontopercentuale'] == "") $scontoPercentuale = 'null';
		else $scontoPercentuale = $_SESSION['scontopercentuale'];
		
		if ($_SESSION['scontocontante'] == "") $scontoContante = 'null';
		else $scontoContante = $_SESSION['scontocontante'];
		
		if ($_SESSION['numerogiornirata'] == "") $numeroGiorniRata = 'null';
		else $numeroGiorniRata = $_SESSION['numerogiornirata'];

		if ($_SESSION['importorata'] == "") $importoRata = 'null';
		else $importoRata = $_SESSION['importorata'];

		if ($_SESSION['importodarateizzare'] == "") $importoDaRateizzare = 'null';
		else $importoDaRateizzare = $_SESSION['importodarateizzare'];

		if ($_SESSION['dataprimarata'] == "") $dataPrimaRata = 'null';
		else $dataPrimaRata = "'" . $_SESSION['dataprimarata'] . "'";
				
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%scontopercentuale%' => $scontoPercentuale,
				'%scontocontante%' => $scontoContante,
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

		if ($_SESSION['scontopercentuale'] == "") $scontoPercentuale = 'null';
		else $scontoPercentuale = $_SESSION['scontopercentuale'];
		
		if ($_SESSION['scontocontante'] == "") $scontoContante = 'null';
		else $scontoContante = $_SESSION['scontocontante'];
		
		if ($_SESSION['numerogiornirata'] == "") $numeroGiorniRata = 'null';
		else $numeroGiorniRata = $_SESSION['numerogiornirata'];

		if ($_SESSION['importorata'] == "") $importoRata = 'null';
		else $importoRata = $_SESSION['importorata'];

		if ($_SESSION['importodarateizzare'] == "") $importoDaRateizzare = 'null';
		else $importoDaRateizzare = $_SESSION['importodarateizzare'];

		if ($_SESSION['dataprimarata'] == "") $dataPrimaRata = 'null';
		else $dataPrimaRata = "'" . $_SESSION['dataprimarata'] . "'";
		
		$replace = array(
				'%idsottopreventivo%' => $idSottoPreventivo,
				'%scontopercentuale%' => $scontoPercentuale,
				'%scontocontante%' => $scontoContante,
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

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->cancellaRatePagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo'])) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->cancellaRatePagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo'])) return TRUE;
			else return FALSE;
		}		
	}

	public function leggiAccontiPreventivo($db, $utility) {
	
		if ($_SESSION['idPreventivo'] != "") {
			$_SESSION['acconti'] = $this->leggiAccontiPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$_SESSION['acconti'] = $this->leggiAccontiPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}
	
	public function leggiRatePagamentoPreventivo($db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			$_SESSION['ratepagamento'] = $this->leggiRatePagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$_SESSION['ratepagamento'] = $this->leggiRatePagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}	
	
	public function generaRatePagamentoPreventivo($db, $utility, $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata) {
		
		if ($_SESSION['idPreventivo'] != "") {
			if ($this->generaRatePagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo'], $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata)) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->generaRatePagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo'], $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata)) return TRUE;
			else return FALSE;
		}		
	}		
	
	public function generaRatePagamentoPreventivoPrincipale($db, $utility, $idPreventivo, $importoDaRateizzare, $dataPrimaRata, $numeroGiorniRata, $importoRata) {

		/**
		 * Se l'importo da rateizzare passato è vuoto non genero le rate e restituisco ok
		 */

		if ($importoDaRateizzare > 0) {

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
	
		if ($importoDaRateizzare > 0) {
	
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