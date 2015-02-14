<?php

require_once 'preventivo.abstract.class.php';

class pagamentoTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/pagamento.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// template ------------------------------------------------

	public function controlliLogici() {

		require_once 'utility.class.php';

		$esito = TRUE;

		if ($this->getImportoDaRateizzare() != "") {
			
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
		else {
			/**
			 * Se l'importo da rateizzare è stato cancellato pulisco tutti i parametri per la rateizzazione
			 */
			$this->setDataPrimaRata("");
			$this->setNumeroGiorniRata("");
			$this->setImportoRata("");
		}
		
		return $esito;
	}

	public function displayPagina() {
	
		require_once 'utility.class.php';
	
		// Template --------------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
		
		/** 		
		 * Creo l'elenco delle rate di pagamento
		 */
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
			$divelencoratepagamento = $testaelencoRatePagamento . $corpoelencoRatePagamento . $piedeelencoRatePagamento;
			$tabelencoratepagamento = "<li><a href='#tabs-2'>%ml.ratepagamento%</a></li>";
		}
		else {
			$divelencoratepagamento = "";
			$tabelencoratepagamento = "";
		}
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
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
				'%accontoiniziocura%' => $this->getAccontoInizioCura(),
				'%accontometacura%' => $this->getAccontoMetaCura(),
				'%saldofinecura%' => $this->getSaldoFineCura(),
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
				'%divelencoratepagamento%' => $divelencoratepagamento,
				'%tabelencoratepagamento%' => $tabelencoratepagamento
		);
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}		
}	
	
?>