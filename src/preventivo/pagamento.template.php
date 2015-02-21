<?php

require_once 'preventivo.abstract.class.php';

class pagamentoTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/pagamento.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// template ------------------------------------------------

	public function controlliLogici($importoDaRateizzare_db, $dataPrimaRata_db, $numeroGiorniRata_db, $importoRata_db,
									$importoDaRateizzare_form, $dataPrimaRata_form, $numeroGiorniRata_form, $importoRata_form) {

		require_once 'utility.class.php';

		$esito = TRUE;

		/**
		 * Se è stato variato un parametro di rateizzazione controllo la congruenza con l'importo che rimane da pagare
		 */	
		if ($this->getImportoDaRateizzare() != "") {
		
			if (($importoDaRateizzare_db != $importoDaRateizzare_form)
			or ($dataPrimaRata_db != $dataPrimaRata_form)
			or ($numeroGiorniRata_db != $numeroGiorniRata_form)
			or ($importoRata_db != $importoRata_form)) {
	
				/**
				 * Controllo che il delta fra l'importo fissato e quello nuovo inserito in pagina
				 * non causi il superamento dell'importo da pagare fuori piano. 
				 * 
				 */
				foreach ($this->getTotalePagatoInPiano() as $row) {
					$totalePagatoInPiano += $row['totale'];
				}
				
				foreach ($this->getTotaleDaPagareInPiano() as $row) {
					$totaleDaPagareInPiano += $row['totale'];
				}
				
				$totaleDaPagareFuoriPiano = $this->calcolaTotalePreventivo() - ($totaleDaPagareInPiano + $totalePagatoInPiano);
				$deltaImporto = $importoDaRateizzare_form - $importoDaRateizzare_db;
				
				if ($deltaImporto > $totaleDaPagareFuoriPiano) {
					$this->setImportoDaRateizzare($importoDaRateizzare_db + $totaleDaPagareFuoriPiano);
				}
				
				if ($this->getDataPrimaRata() == "") {
					$esito = FALSE;
					$this->setStyleDataPrimaRata("border-color:#ff0000; border-width:2px;");
					$this->setTipDataPrimaRata("%ml.dataprimaratamancante%");				
				}
						
				if ($this->getNumeroGiorniRata() == "") {
					$esito = FALSE;
					$this->setStyleNumeroGiorniRata("border-color:#ff0000; border-width:2px;");
					$this->setTipNumeroGiorniRata("%ml.numerogiorniratamancante%");				
				}
								
				if ($this->getImportoRata() == "") {
					$esito = FALSE;
					$this->setStyleImportoRata("border-color:#ff0000; border-width:2px;");
					$this->setTipImportoRata("%ml.importoratamancante%");				
				}
			}
		}
		else {
			/**
			 * Se l'importo da rateizzare è stato cancellato pulisco tutti i parametri per la rateizzazione
			 */
			$this->setDataPrimaRata("");
			$this->setNumeroGiorniRata("");
			$this->setImportoRata("");
		}

		/**
		 * Controllo campi per acconti
		 */		
		if ($this->getDataScadenzaAcconto() != "") {
			
			if ($this->getDescrizioneAcconto() == "") {
				$esito = FALSE;
				$this->setStyleDescrizioneAcconto("border-color:#ff0000; border-width:2px;");
				$this->setTipDescrizioneAcconto("%ml.descrizionemancante%");
			}

			if ($this->getImportoAcconto() == "") {
				$esito = FALSE;
				$this->setStyleImportoAcconto("border-color:#ff0000; border-width:2px;");
				$this->setTipImportoAcconto("%ml.importoratamancante%");
			}
			else {
				
				foreach ($this->getTotalePagatoInPiano() as $row) {
					$totalePagatoInPiano += $row['totale'];
				}
				
				foreach ($this->getTotaleDaPagareInPiano() as $row) {
					$totaleDaPagareInPiano += $row['totale'];
				}
				
				$totaleDaPagareFuoriPiano = $this->calcolaTotalePreventivo() - ($totaleDaPagareInPiano + $totalePagatoInPiano);
				
				if ($this->getImportoAcconto() > $totaleDaPagareFuoriPiano) {
					$this->setImportoAcconto($totaleDaPagareFuoriPiano);
				}				
			}
		}
		
		return $esito;
	}

	public function displayPagina() {
	
		require_once 'utility.class.php';
	
		// Template --------------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;

		// Gestione del messaggio -------------------

		$text0 = $this->getMessaggio();		
		
		if ($text0 != "") {
			$replace = array('%messaggio%' => $text0 );			
			if (strpos($text0,'Ko')) $template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			else $template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);			
			echo $utility->tailTemplate($template);				
		}
		
		$singoli = substr(str_replace(",",".",str_replace(".","",$this->getTotalePreventivoDentiSingoli())),3);		
		$gruppi = substr(str_replace(",",".",str_replace(".","",$this->getTotalePreventivoGruppi())),3);
		$cure = substr(str_replace(",",".",str_replace(".","",$this->getTotalePreventivoCure())),3);
		
		/**
		 * Gestione dei totali
		 */
		$totalePreventivo = $singoli + $gruppi + $cure;
		
		foreach ($this->getTotalePagatoInPiano() as $row) {
			$totalePagatoInPiano += $row['totale'];
		}
		
		foreach ($this->getTotaleDaPagareInPiano() as $row) {
			$totaleDaPagareInPiano += $row['totale'];
		}
		
		$totaleDaPagareFuoriPiano = $this->calcolaTotalePreventivo() - ($totaleDaPagareInPiano + $totalePagatoInPiano);
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
				'%totale%' => $this->getTotalePreventivoLabel(),
				'%totpreventivo%' => '&euro;' . number_format($this->calcolaTotalePreventivo(), 2, ',', '.'),
				'%totsingoli%' => $this->getTotalePreventivoDentiSingoli(),
				'%totgruppi%' => $this->getTotalePreventivoGruppi(),
				'%totcure%' => $this->getTotalePreventivoCure(),
				'%totalePagatoInPiano%' => '&euro;' . number_format($totalePagatoInPiano, 2, ',', '.'),
				'%totaleDaPagareInPiano%' => '&euro;' . number_format($totaleDaPagareInPiano, 2, ',', '.'),
				'%totaleDaPagareFuoriPiano%' => '&euro;' . number_format($totaleDaPagareFuoriPiano, 2, ',', '.'),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita(),
				'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
				'%azioneGruppi%' => $this->getAzioneGruppi(),
				'%azioneCure%' => $this->getAzioneCure(),
				'%azionePagamento%' => $this->getAzionePagamento(),
				'%cognomeRicerca%' => $this->getCognomeRicerca(),
				'%idPaziente%' => $this->getIdPaziente(),
				'%idListino%' => $this->getIdListino(),
				'%idPreventivo%' => $this->getIdPreventivo(),
				'%idPreventivoPrincipale%' => $this->getIdPreventivoPrincipale(),
				'%idSottoPreventivo%' => $this->getIdSottoPreventivo(),
				'%stato%' => $this->getStato(),
				'%scontopercentuale%' => $this->getScontoPercentuale(),
				'%scontocontante%' => $this->getScontoContante(),
				'%datascadenzaacconto%' => $this->getDataScadenzaAcconto(),
				'%datascadenzaaccontoStyle%' => $this->getStyleDataScadenzaAcconto(),
				'%datascadenzaaccontoTip%' => $this->getTipDataScadenzaAcconto(),
				'%descrizioneacconto%' => $this->getDescrizioneAcconto(),
				'%descrizioneaccontoStyle%' => $this->getStyleDescrizioneAcconto(),
				'%descrizioneaccontoTip%' => $this->getTipDescrizioneAcconto(),
				'%importoacconto%' => $this->getImportoAcconto(),
				'%importoaccontoStyle%' => $this->getStyleImportoAcconto(),
				'%importoaccontoTip%' => $this->getTipImportoAcconto(),
				'%elencoacconti%' => $this->creaElencoAcconti(),
				'%importodarateizzare%' => $this->getImportoDaRateizzare(),
				'%dataprimarata%' => $this->getDataPrimaRata(),
				'%dataprimarataStyle%' => $this->getStyleDataPrimaRata(),
				'%dataprimarataTip%' => $this->getTipDataPrimaRata(),
				'%dataprimarataDisable%' => "",
				'%numerogiornirata%' => $this->getNumeroGiorniRata(),
				'%numerogiornirataStyle%' => $this->getStyleNumeroGiorniRata(),
				'%numerogiornirataTip%' => $this->getTipNumeroGiorniRata(),
				'%numerogiornirataDisable%' => "",
				'%importorata%' => $this->getImportoRata(),
				'%importorataStyle%' => $this->getStyleImportoRata(),
				'%importorataTip%' => $this->getTipImportoRata(),
				'%importorataDisable%' => "",
				'%divelencoratepagamento%' => $this->creaElencoRatePagamento(),
				'%tabelencoratepagamento%' => $this->creaTabRatePagamento()
		);
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}	
	
	public function calcolaTotalePreventivo() {
		
		$singoli = substr(str_replace(",",".",str_replace(".","",$this->getTotalePreventivoDentiSingoli())),3);
		$gruppi = substr(str_replace(",",".",str_replace(".","",$this->getTotalePreventivoGruppi())),3);
		$cure = substr(str_replace(",",".",str_replace(".","",$this->getTotalePreventivoCure())),3);
		
		return $singoli + $gruppi + $cure;		
	}
	
	public function creaElencoAcconti() {

		if ($this->getAcconti() != "") {
				
			$testaElencoAcconti = "<table class='result-alt'><tbody>";
				
			$corpoElencoAcconti = "";
			foreach ($this->getAcconti() as $row) {
				if ($row['stato'] == '00') {
					$stato = '%ml.dapagare%';
					$class = "class='pagataOff'";
				}
				if ($row['stato'] == '01') {
					$stato = '%ml.pagato%';
					$class = "class='pagataOn'";
				}
				$corpoElencoAcconti .= "<tr height='30' " . $class . ">";
				$corpoElencoAcconti .= "<td width='80'>" . $row['datascadenza']  . "</td><td width='225'>" . $row['descrizione']  . "</td><td width='160' align='right'>&euro;" . $row['importo']  . "</td><td width='106' align='center'>" . $stato  . "</td>";
				if ($row['stato'] == '00') {
					$corpoElencoAcconti .= "<td id='icons' width='35'><a class='tooltip' href='../preventivo/cancellaAccontoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idAcconto=" . $row['idacconto'] . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $this->getIdPreventivo() . "&idPreventivoPrincipale=" . $this->getIdPreventivoPrincipale() . "&idSottoPreventivo=" . $this->getIdSottoPreventivo() . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "&totalesingoli=" . $this->getTotalePreventivoDentiSingoli() . "&totalegruppi=" . $this->getTotalePreventivoGruppi() . "&totalecure=" . $this->getTotalePreventivoCure() . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a></td>";
				}
				else {
					$corpoElencoAcconti .= "<td width='33'>&nbsp;</td>";
				}
				$corpoElencoAcconti .= "</tr>";
			}
			$piedeElencoAcconti = "</tbody></table>";
			return $testaElencoAcconti . $corpoElencoAcconti . $piedeElencoAcconti;
		}
		else { return ""; }
	}
	
	public function creaElencoRatePagamento() {
		
		if ($this->getRatePagamento() != "") {
				
			$testaelencoRatePagamento = "<div id='tabs-2'><div class='scroll'><table class='result-alt' id='resultTable'><thead><tr><th>Data Scadenza</th><th>Importo</th><th>Stato</th></tr></thead><tbody>";
				
			$corpoelencoRatePagamento = "";
			foreach ($this->getRatePagamento() as $row) {
				if ($row['stato'] == '00') {
					$stato = '%ml.dapagare%';
					$class = "class='pagataOff'";
				}
				if ($row['stato'] == '01') {
					$stato = '%ml.pagata%';
					$class = "class='pagataOn'";
				}
				$corpoelencoRatePagamento .= "<tr " . $class . "><td width='100'>" . $row['datascadenza']  . "</td><td width='100' align='right'>&euro;" . $row['importo']  . "</td><td width='100' align='center'>" . $stato  . "</td></tr>";
			}
			$piedeelencoRatePagamento = "</tbody></table></div></div>";
			return $testaelencoRatePagamento . $corpoelencoRatePagamento . $piedeelencoRatePagamento;
		}
		else {
			return "";
		}
		
	}
	
	public function creaTabRatePagamento() {

		if ($this->getRatePagamento() != "") {
			return "<li><a href='#tabs-2'>%ml.ratepagamento%</a></li>";				
		}
		else return "";		
	}
}	
	
?>