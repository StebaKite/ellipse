<?php

require_once 'preventivo.abstract.class.php';

class pagamentoTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/pagamento.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// template ------------------------------------------------

	public function controlliLogici($scontoPercentuale_db, $scontoContante_db, $importoDaRateizzare_db, $dataPrimaRata_db, $numeroGiorniRata_db, $importoRata_db,
									$scontoPercentuale_form, $scontoContante_form, $importoDaRateizzare_form, $dataPrimaRata_form, $numeroGiorniRata_form, $importoRata_form) {

		require_once 'utility.class.php';

		$esito = TRUE;

		/**
		 * Calcolo l'importo o la percentuale di sconto
		 */
		
 		if ($scontoPercentuale_db != $scontoPercentuale_form) {
			$_SESSION['scontocontante'] = ($_SESSION['totalepreventivo'] / 100) * $_SESSION['scontopercentuale'];			// calcolo il contante da sommare al residuo fuori piano
 			$_SESSION['totaledapagarefuoripiano'] = ($_SESSION['totaledapagarefuoripiano'] - $_SESSION['scontocontante']);	// tolgo lo sconto al totale fuori piano
 		}
 		elseif ($scontoContante_db != $scontoContante_form) {
 			$_SESSION['scontopercentuale'] = ($_SESSION['scontocontante'] * 100) / $_SESSION['totalepreventivo'];			// calcolo la percentuale
 			$_SESSION['totaledapagarefuoripiano'] = ($_SESSION['totaledapagarefuoripiano'] - $_SESSION['scontocontante']);	// tolgo lo sconto al totale fuori piano 			
 		}
		
		/**
		 * Se è stato variato un parametro di rateizzazione controllo la congruenza con l'importo che rimane da pagare
		 */	
		
		if ($importoDaRateizzare_form != "") {
		
			if (($importoDaRateizzare_db != $importoDaRateizzare_form)
			or ($dataPrimaRata_db != $dataPrimaRata_form)
			or ($numeroGiorniRata_db != $numeroGiorniRata_form)
			or ($importoRata_db != $importoRata_form)) {
	
				/**
				 * Controllo che il delta fra l'importo fissato e quello nuovo inserito in pagina
				 * non causi il superamento dell'importo da pagare fuori piano al netto dello sconto
				 * 
				 */		
				
				$deltaImporto = $importoDaRateizzare_form - $importoDaRateizzare_db;
				
				if ($deltaImporto > $_SESSION['totaledapagarefuoripiano']) {
					$_SESSION['importodarateizzare'] = $importoDaRateizzare_db + $_SESSION['totaledapagarefuoripiano'];
				}
				$_SESSION['totaledapagarefuoripiano'] = $_SESSION['totaledapagarefuoripiano'] - $_SESSION['importodarateizzare'];
				
				if ($_SESSION['importodarateizzare'] == 0) {
					$_SESSION['dataprimarata'] = "";
					$_SESSION['numerogiornirata'] = "";
					$_SESSION['importorata'] = "";
				}
				else {
					if ($dataPrimaRata_form == "") {
							
						$esito = FALSE;
						$_SESSION['styledataprimarata'] = "border-color:#ff0000; border-width:2px;";
						$_SESSION['tipdataprimarata'] = "%ml.dataprimaratamancante%";
					}
					else {
						$_SESSION['dataprimarata'] = "$dataPrimaRata_form";
					}
					
					if ($numeroGiorniRata_form == "") {
						$esito = FALSE;
						$_SESSION['stylenumerogiornirata'] = "border-color:#ff0000; border-width:2px;";
						$_SESSION['tipnumerogiornirata'] = "%ml.numerogiorniratamancante%";
					}
					else {
						$_SESSION['numerogiornirata'] = "$numeroGiorniRata_form";
					}
					
					if ($importoRata_form == "") {
						$esito = FALSE;
						$_SESSION['styleimportorata'] = "border-color:#ff0000; border-width:2px;";
						$_SESSION['tipimportorata'] = "%ml.importoratamancante%";
					}
					else {
						$_SESSION['importorata'] = "$importoRata_form";
					}													
				}				
			}
		}
		else {
			/**
			 * Se l'importo da rateizzare è stato cancellato pulisco tutti i parametri per la rateizzazione
			 */
			$_SESSION['importodarateizzare'] = "";
			$_SESSION['dataprimarata'] = "";
			$_SESSION['numerogiornirata'] = "";
			$_SESSION['importorata'] = "";
		}

		/**
		 * Controllo campi per acconti
		 */
		
		if ($_SESSION['datascadenzaacconto'] != "") {
			
			if ($_SESSION['descrizioneacconto'] == "") {
				$esito = FALSE;
				$_SESSION['styledescrizioneacconto'] = "border-color:#ff0000; border-width:2px;";
				$_SESSION['tipdescrizioneacconto'] = "%ml.descrizionemancante%";
			}

			if ($_SESSION['importoacconto'] == "") {
				$esito = FALSE;
				$_SESSION['styleimportoacconto'] = "border-color:#ff0000; border-width:2px;";
				$_SESSION['tipimportoacconto'] = "%ml.importoratamancante%";
			}
			else {
				
				if ($_SESSION['importoacconto'] > $_SESSION['totaledapagarefuoripiano']) {
					$_SESSION['importoacconto'] = $_SESSION['totaledapagarefuoripiano'];
				}
				$_SESSION['totaledapagarefuoripiano'] = $_SESSION['totaledapagarefuoripiano'] - $_SESSION['importoacconto'];
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
				
		$totaleDaPagareFuoriPiano = $_SESSION['totaledapagarefuoripiano'];
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
				'%totale%' => $this->getTotalePreventivoLabel(),
				'%totpreventivo%' => '&euro;' . number_format($_SESSION['totalepreventivo'], 2, ',', '.'),
				'%totalePagatoProgressBar%' => ($_SESSION['totalepagatoinpiano'] * 100) / $_SESSION['totalepreventivo'],
				'%totaleDaPagareProgressBar%' => ($_SESSION['totaledapagareinpiano'] * 100) / $_SESSION['totalepreventivo'],
				'%totaleFuoriPianoProgressBar%' => ($_SESSION['totaledapagarefuoripiano'] * 100) / $_SESSION['totalepreventivo'],
				'%totalePagatoInPiano%' => '&euro;' . number_format($_SESSION['totalepagatoinpiano'], 2, ',', '.'),
				'%totaleDaPagareInPiano%' => '&euro;' . number_format($_SESSION['totaledapagareinpiano'], 2, ',', '.'),
				'%totaleDaPagareFuoriPiano%' => '&euro;' . number_format($_SESSION['totaledapagarefuoripiano'], 2, ',', '.'),
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
				'%azioneGruppi%' => $this->getAzioneGruppi(),
				'%azioneCure%' => $this->getAzioneCure(),
				'%azionePagamento%' => $this->getAzionePagamento(),
				'%idPreventivo%' => $_SESSION['idPreventivo'],
				'%idPreventivoPrincipale%' => $_SESSION['idPreventivoPrincipale'],
				'%idSottoPreventivo%' => $_SESSION['idSottoPreventivo'],
				'%stato%' => $_SESSION['stato'],
				'%scontopercentuale%' => $_SESSION['scontopercentuale'],
				'%scontocontante%' => $_SESSION['scontocontante'],
				'%datascadenzaacconto%' => $_SESSION['datascadenzaacconto'],
				'%datascadenzaaccontoStyle%' => $_SESSION['styledatascadenzaacconto'],
				'%datascadenzaaccontoTip%' => $_SESSION['tipdatascadenzaacconto'],
				'%descrizioneacconto%' => $_SESSION['descrizioneacconto'],
				'%descrizioneaccontoStyle%' => $_SESSION['styledescrizioneacconto'],
				'%descrizioneaccontoTip%' => $_SESSION['tipdescrizioneacconto'],
				'%importoacconto%' => $_SESSION['importoacconto'],
				'%importoaccontoStyle%' => $_SESSION['styleimportoacconto'],
				'%importoaccontoTip%' => $_SESSION['tipimportoacconto'],
				'%elencoacconti%' => $this->creaElencoAcconti(),
				'%importodarateizzare%' => $_SESSION['importodarateizzare'],
				'%dataprimarata%' => $_SESSION['dataprimarata'],
				'%dataprimarataStyle%' => $_SESSION['styledataprimarata'],
				'%dataprimarataTip%' => $_SESSION['tipdataprimarata'],
				'%dataprimarataDisable%' => "",
				'%numerogiornirata%' => $_SESSION['numerogiornirata'],
				'%numerogiornirataStyle%' => $_SESSION['stylenumerogiornirata'],
				'%numerogiornirataTip%' => $_SESSION['tipnumerogiornirata'],
				'%numerogiornirataDisable%' => "",
				'%importorata%' => $_SESSION['importorata'],
				'%importorataStyle%' => $_SESSION['styleimportorata'],
				'%importorataTip%' => $_SESSION['tipimportorata'],
				'%importorataDisable%' => "",
				'%confermaTip%'=> $this->getConfermaTip(),
				'%divelencoratepagamento%' => $this->creaElencoRatePagamento(),
				'%tabelencoratepagamento%' => $this->creaTabRatePagamento()
		);
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}	
	
	public function creaElencoAcconti() {

		if ($_SESSION['acconti'] != "") {
				
			$testaElencoAcconti = "<table class='result-alt'><tbody>";
				
			$corpoElencoAcconti = "";
			foreach ($_SESSION['acconti'] as $row) {
				if ($row['stato'] == '00') {
					$stato = '%ml.dapagare%';
					$class = "class='pagataOff'";
				}
				if ($row['stato'] == '01') {
					$stato = '%ml.pagato%';
					$class = "class='pagataOn'";
				}
				$corpoElencoAcconti .= "<tr height='30' " . $class . ">";
				$corpoElencoAcconti .= "<td width='80'>" . $row['datascadenza']  . "</td><td width='261'>" . $row['descrizione']  . "</td><td width='120' align='right'>&euro;" . $row['importo']  . "</td><td width='110' align='center'>" . $stato  . "</td>";
				if ($row['stato'] == '00') {
					$corpoElencoAcconti .= "<td id='icons' width='35'><a class='tooltip' href='../preventivo/cancellaAccontoFacade.class.php?modo=start&idAcconto=" . $row['idacconto'] . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a></td>";
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
		
		if ($_SESSION['ratepagamento'] != "") {
				
			$testaelencoRatePagamento = "<div id='tabs-2'><div class='scroll'><table class='result-alt' id='resultTable'><thead><tr><th>Data Scadenza</th><th>Importo</th><th>Stato</th></tr></thead><tbody>";
				
			$corpoelencoRatePagamento = "";
			foreach ($_SESSION['ratepagamento'] as $row) {
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

		if ($_SESSION['ratepagamento'] != "") {
			return "<li><a href='#tabs-2'>%ml.ratepagamento%</a></li>";				
		}
		else return "";		
	}
}	
	
?>