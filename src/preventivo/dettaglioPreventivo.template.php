<?php

require_once 'preventivo.abstract.class.php';

class dettaglioPreventivoTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/preventivo.dettaglio.form.html";
	private static $paginaSingoli = "/preventivo/preventivo.dettagliosingoli.form.html";
	private static $paginaGruppi = "/preventivo/preventivo.dettagliogruppi.form.html";
	private static $paginaCure = "/preventivo/preventivo.dettagliocure.form.html";
	public static $vociPreventivoDentiSingoli;
	public static $vociPreventivoGruppi;
	public static $vociPreventivoCureTab;
	public static $vociPreventivoCure;
	public static $dettaglioPreventivo;

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters --------------------------------------------------------------------

	public function setVociPreventivoDentiSingoli($vociPreventivoDentiSingoli) {
		self::$vociPreventivoDentiSingoli = $vociPreventivoDentiSingoli;
	}
	public function setVociPreventivoGruppi($vociPreventivoGruppi) {
		self::$vociPreventivoGruppi = $vociPreventivoGruppi;
	}
	public function setVociPreventivoCure($vociPreventivoCure) {
		self::$vociPreventivoCure = $vociPreventivoCure;
	}
	public function setDettaglioPreventivo($dettaglioPreventivo) {
		self::$dettaglioPreventivo = $dettaglioPreventivo;
	}

	// Getters --------------------------------------------------------------------

	public function getVociPreventivoDentiSingoli() {
		return self::$vociPreventivoDentiSingoli;
	}
	public function getVociPreventivoGruppi() {
		return self::$vociPreventivoGruppi;
	}
	public function getVociPreventivoCure() {
		return self::$vociPreventivoCure;
	}
	public function getDettaglioPreventivo() {
		return self::$dettaglioPreventivo;
	}

	// ----------------------------------------------------------------------------

	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$form = self::$root . $array['template'] . self::$pagina;
		$formSingoli = self::$root . $array['template'] . self::$paginaSingoli;
		$formGruppi = self::$root . $array['template'] . self::$paginaGruppi;
		$formCure = self::$root . $array['template'] . self::$paginaCure;
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azionePreventivo%' => $this->getAzionePreventivo(),
				'%azionePreventivoTip%' => $this->getAzionePreventivoTip(),
				'%azionePreventivoLabelBottone%' => $this->getAzionePreventivoLabelBottone(),
				'%cognomeRicerca%' => $this->getCognomeRicerca(),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita(),
				'%datainserimento%' => $this->getDataInserimento(),
				'%stato%' => $this->getStato(),
				'%idPaziente%' => $this->getIdPaziente(),
				'%idListino%' => $this->getIdListino(),
				'%idPreventivo%' => $this->getIdPreventivo(),
				'%idPreventivoPrincipale%' => $this->getIdPreventivoPrincipale(),
				'%idSottoPreventivo%' => $this->getIdSottoPreventivo(),
				'%thAzioni%' => $this->getIntestazioneColonnaAzioni()
		);
		
		if ($this->getStato() == '00') $replace['%stato%'] = '%ml.proposto%';
		if ($this->getStato() == '01') $replace['%stato%'] = '%ml.accettato%';
		if ($this->getStato() == '02') $replace['%stato%'] = '%ml.parzialmenteaccettato%';
		if ($this->getStato() == '03') $replace['%stato%'] = '%ml.splittato%';		
		
		$this->setTotalePreventivo(0);
		$replace = $this->preparaTabellaVociDentiSingoli($utility, $replace, $formSingoli, $this->getTitoloPagina());
		$replace = $this->preparaTabellaVociDentiGruppi($utility, $replace, $formGruppi, $this->getTitoloPagina());
		$replace = $this->preparaTabellaVociCure($utility, $replace, $formCure, $this->getTitoloPagina());
		
		$replace['%totalePreventivo%'] = number_format($this->getTotalePreventivo(), 2, ',', '.');
		$replace['%classeTotalePreventivo%'] = 'totalePreventivoAccettato';
		
		// display della pagina completata ------------------------------------------------------------------------
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
		
	public function preparaTabellaVociDentiSingoli($utility, $replace, $formSingoli, $titoloPagina) {
		
		if ($this->getVociPreventivoDentiSingoli()) {
		
			$totaleSingoli = 0;
			$riepilogoVociPreventivoDentiSingoli = "";
			$replace['%riepilogoDentiSingoliTab%'] = "<li><a href='#tabs-1'>%ml.dentiSingoli%</a></li>";
		
			$denteBreak = "";
			foreach ($this->getVociPreventivoDentiSingoli() as $row) {
				$dente = split("_", $row['nomecampoform']);
				if ($dente[1] != $denteBreak) {
					$riepilogoVociPreventivoDentiSingoli .= "<tr>";
					$riepilogoVociPreventivoDentiSingoli .= "<td align='center'>" . $dente[1] . "</td><td align='center'>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

					/**
					 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
					 */
					if (strpos($titoloPagina, 'dettaglio')) {

						/**
						 * se il preventivo è "Accettato" non permette la modifica della voce
						 */
						if ($this->getStato() != '01') $riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
						else $riepilogoVociPreventivoDentiSingoli .= "<td>&nbsp;</td>";
						
						$riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
					}
					
					$riepilogoVociPreventivoDentiSingoli .= "</tr>";
						
					$denteBreak = $dente[1];
				}
				else {
					$riepilogoVociPreventivoDentiSingoli .= "<tr>";
					$riepilogoVociPreventivoDentiSingoli .= "<td></td><td align='center'>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

					/**
					 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
					 */
					if (strpos($titoloPagina, 'dettaglio')) {

						/**
						 * se il preventivo è "Accettato" non permette la modifica della voce
						 */
						if ($this->getStato() != '01') $riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
						else $riepilogoVociPreventivoDentiSingoli .= "<td>&nbsp;</td>";
						
						$riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";						
					}
											
					$riepilogoVociPreventivoDentiSingoli .= "</tr>";
				}
				$totaleSingoli += $row['prezzo'];
			}
		
			$replace['%totaleSingoli%'] = number_format($totaleSingoli, 2, ',', '.');
			$replace['%riepilogoDentiSingoli%'] = $riepilogoVociPreventivoDentiSingoli;
			$template = $utility->tailFile($utility->getTemplate($formSingoli), $replace);
			$replace['%riepilogoDentiSingoliDiv%'] = $template;
		
		}
		else {
			$replace['%riepilogoDentiSingoliTab%'] = "";
			$replace['%riepilogoDentiSingoliDiv%'] = "";
			$replace['%riepilogoDentiSingoli%'] = "";
		}		
		$this->setTotalePreventivo($this->getTotalePreventivo() + $totaleSingoli);
		return $replace;		
	}	

	public function preparaTabellaVociDentiGruppi($utility, $replace, $formGruppi, $titoloPagina) {
		
		if ($this->getVociPreventivoGruppi()) {
		
			$totaleGruppi = 0;
			$riepilogoVociPreventivoGruppi = "";
			$replace['%riepilogoGruppiTab%'] = "<li><a href='#tabs-2'>%ml.gruppi%</a></li>";
		
			$voceListinoBreak = "";
				
			foreach ($this->getVociPreventivoGruppi() as $row) {
		
				$dente = split("_", $row['nomecampoform']);
		
				if (trim($row['codicevocelistino']) != trim($voceListinoBreak)) {
					$riepilogoVociPreventivoGruppi .= "<tr>";
					$riepilogoVociPreventivoGruppi .= "<td align='center'>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td align='center'>" . $dente[1] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

					/**
					 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
					 */
					if (strpos($titoloPagina, 'dettaglio')) {

						/**
						 * se il preventivo è "Accettato" non permette la modifica della voce
						 */
						if ($this->getStato() != '01') $riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
						else $riepilogoVociPreventivoGruppi .= "<td>&nbsp;</td>";
						
						$riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
					}
					
					$riepilogoVociPreventivoGruppi .= "</tr>";
					$voceListinoBreak = $row['codicevocelistino'];
				}
				else {
					$riepilogoVociPreventivoGruppi .= "<tr>";
					$riepilogoVociPreventivoGruppi .= "<td></td><td></td><td align='center'>" . $dente[1] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

					/**
					 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
					 */
					if (strpos($titoloPagina, 'dettaglio')) {
					
						/**
						 * se il preventivo è "Accettato" non permette la modifica della voce
						 */
						if ($this->getStato() != '01') $riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
						else $riepilogoVociPreventivoGruppi .= "<td>&nbsp;</td>";
					
						$riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
					}
						
					$riepilogoVociPreventivoGruppi .= "</tr>";
				}
				$totaleGruppi += $row['prezzo'];
			}
				
			$replace['%totaleGruppi%'] = number_format($totaleGruppi, 2, ',', '.');
			$replace['%riepilogoGruppi%'] = $riepilogoVociPreventivoGruppi;
			$template = $utility->tailFile($utility->getTemplate($formGruppi), $replace);
			$replace['%riepilogoGruppiDiv%'] = $template;
		}
		else {
			$replace['%riepilogoGruppiTab%'] = "";
			$replace['%riepilogoGruppiDiv%'] = "";
			$replace['%riepilogoGruppi%'] = "";
		}
		$this->setTotalePreventivo($this->getTotalePreventivo() + $totaleGruppi);
		return $replace;
	}		

	public function preparaTabellaVociCure($utility, $replace, $formCure, $titoloPagina) {
		
		if ($this->getVociPreventivoCure()) {
		
			$totaleCure = 0;
			$riepilogoVociPreventivoCure = "";
			$replace['%riepilogoCureTab%'] = "<li><a href='#tabs-3'>%ml.cure%</a></li>";
				
			foreach ($this->getVociPreventivoCure() as $row) {
				$riepilogoVociPreventivoCure .= "<tr>";
				$riepilogoVociPreventivoCure .= "<td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

				/**
				 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
				 */
				if (strpos($titoloPagina, 'dettaglio')) {

					/**
					 * se il preventivo è "Accettato" non permette la modifica della voce
					 */
					if ($this->getStato() != '01') $riepilogoVociPreventivoCure .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
					else $riepilogoVociPreventivoCure .= "<td>&nbsp;</td>";
					
					$riepilogoVociPreventivoCure .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
				}

				$riepilogoVociPreventivoCure .= "</tr>";
				$totaleCure += $row['prezzo']; 				
			}
				
			$replace['%totaleCure%'] = number_format($totaleCure, 2, ',', '.');
			$replace['%riepilogoCure%'] = $riepilogoVociPreventivoCure;
			$template = $utility->tailFile($utility->getTemplate($formCure), $replace);
			$replace['%riepilogoCureDiv%'] = $template;
		}
		else {
			$replace['%riepilogoCureTab%'] = "";
			$replace['%riepilogoCureDiv%'] = "";
			$replace['%riepilogoCure%'] = "";
		}
		$this->setTotalePreventivo($this->getTotalePreventivo() + $totaleCure);
		return $replace;
	}
}

?>