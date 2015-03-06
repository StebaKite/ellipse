<?php

require_once 'preventivo.abstract.class.php';

class dettaglioPreventivoTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/preventivo.dettaglio.form.html";
	private static $paginaSingoli = "/preventivo/preventivo.dettagliosingoli.form.html";
	private static $paginaGruppi = "/preventivo/preventivo.dettagliogruppi.form.html";
	private static $paginaCure = "/preventivo/preventivo.dettagliocure.form.html";
	public static $vociPreventivoCureTab;
	public static $dettaglioPreventivo;

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters --------------------------------------------------------------------

	public function setDettaglioPreventivo($dettaglioPreventivo) {
		self::$dettaglioPreventivo = $dettaglioPreventivo;
	}

	// Getters --------------------------------------------------------------------

	public function getDettaglioPreventivo() {
		return self::$dettaglioPreventivo;
	}

	// ----------------------------------------------------------------------------

	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------
		
		$db = new database();
		
		$db->beginTransaction();
				
		$utility = new utility();
		$array = $utility->getConfig();
		
		$form = self::$root . $array['template'] . self::$pagina;
		$formSingoli = self::$root . $array['template'] . self::$paginaSingoli;
		$formGruppi = self::$root . $array['template'] . self::$paginaGruppi;
		$formCure = self::$root . $array['template'] . self::$paginaCure;

		/**
		 * Gestisco il messaggio eventualmente impostato da altre funzioni
		 */
		$text0 = $this->getMessaggio();
		if ($text0 != "") {
			$replace = array('%messaggio%' => $text0);			
			if (strpos($text0,'Ko')) $template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			else $template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);			
			echo $utility->tailTemplate($template);
		};		
		
		/**
		 * Preparo il bottone Accetta, Rinuncia, Cancella preventivo
		 */
		if ($this->getAzionePreventivo() != '') {
			
			$bottoneAzionePreventivo  = "<td>";
			$bottoneAzionePreventivo .= "<form class='tooltip' method='post' action='" . $this->getAzionePreventivo() . "' >";
			$bottoneAzionePreventivo .= "<button class='button' title='" . $this->getAzionePreventivoTip() . "' >" . $this->getAzionePreventivoLabelBottone() . "</button>";
			$bottoneAzionePreventivo .= "<input type='hidden' name='usa-sessione' value='true'/>";
			$bottoneAzionePreventivo .= "</form>";
			$bottoneAzionePreventivo .= "</td>";			
		}
		else {
			$bottoneAzionePreventivo = '';
		}
		
		if ($_SESSION['idPreventivo'] != "") $idPreventivo = $_SESSION['idPreventivo'];
		if ($_SESSION['idSottoPreventivo'] != "") $idPreventivo = $_SESSION['idSottoPreventivo'];
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azionePreventivo%' => $this->getAzionePreventivo(),
				'%azionePreventivoTip%' => $this->getAzionePreventivoTip(),
				'%azionePreventivoLabelBottone%' => $this->getAzionePreventivoLabelBottone(),
				'%bottoneAzionePreventivo%' => $bottoneAzionePreventivo,
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%datainserimento%' => $_SESSION['dataInserimento'],
				'%idPreventivo%' => $idPreventivo,
				'%thAzioni%' => $this->getIntestazioneColonnaAzioni()
		);
		
		if ($_SESSION['stato'] == '00') $replace['%stato%'] = '%ml.proposto%';
		if ($_SESSION['stato'] == '01') $replace['%stato%'] = '%ml.accettato%';
		if ($_SESSION['stato'] == '02') $replace['%stato%'] = '%ml.parzialmenteaccettato%';
		if ($_SESSION['stato'] == '03') $replace['%stato%'] = '%ml.splittato%';		
		
		$replace = $this->preparaTabellaVociDentiSingoli($utility, $replace, $formSingoli, $this->getTitoloPagina());
		$replace = $this->preparaTabellaVociDentiGruppi($utility, $replace, $formGruppi, $this->getTitoloPagina());
		$replace = $this->preparaTabellaVociCure($utility, $replace, $formCure, $this->getTitoloPagina());
		
		$replace['%totalePreventivo%'] = number_format($this->calcolaTotalePreventivo($db), 2, ',', '.');
		$replace['%classeTotalePreventivo%'] = 'totalePreventivoAccettato';

		$db->commitTransaction();
		
		// display della pagina completata ------------------------------------------------------------------------
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
		
	public function preparaTabellaVociDentiSingoli($utility, $replace, $formSingoli, $titoloPagina) {
		
		if ($_SESSION['vociPreventivoDentiSingoli']) {
		
			$totaleSingoli = 0;
			$riepilogoVociPreventivoDentiSingoli = "";
			$replace['%riepilogoDentiSingoliTab%'] = "<li><a href='#tabs-1'>%ml.dentiSingoli%</a></li>";
		
			$denteBreak = "";
			foreach ($_SESSION['vociPreventivoDentiSingoli'] as $row) {
				
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
						 * 
						 *   (per ora no, SB 17/2/2015)
						 */
// 						if ($this->getStato() != '01') $riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
// 						else $riepilogoVociPreventivoDentiSingoli .= "<td>&nbsp;</td>";
						
						$riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&tabella=Singoli&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";						
						$riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
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
						 * 
						 *   (per ora no, SB 17/2/2015)
						 */
// 						if ($this->getStato() != '01') $riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
// 						else $riepilogoVociPreventivoDentiSingoli .= "<td>&nbsp;</td>";
						
						$riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&tabella=Singoli&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";						
						$riepilogoVociPreventivoDentiSingoli .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
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
		return $replace;		
	}	

	public function preparaTabellaVociDentiGruppi($utility, $replace, $formGruppi, $titoloPagina) {
		
		if ($_SESSION['vociPreventivoGruppi']) {
		
			$totaleGruppi = 0;
			$riepilogoVociPreventivoGruppi = "";
			$replace['%riepilogoGruppiTab%'] = "<li><a href='#tabs-2'>%ml.gruppi%</a></li>";
		
			$descrizioneVoceBreak = "";
				
			foreach ($_SESSION['vociPreventivoGruppi'] as $row) {
		
				$dente = split("_", $row['nomecampoform']);
		
				if (trim($row['descrizionevoce']) != trim($descrizioneVoceBreak)) {
					$riepilogoVociPreventivoGruppi .= "<tr>";
					$riepilogoVociPreventivoGruppi .= "<td align='center'>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td align='center'>" . $dente[1] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

					/**
					 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
					 */
					if (strpos($titoloPagina, 'dettaglio')) {

						/**
						 * se il preventivo è "Accettato" non permette la modifica della voce
						 * 
						 * (per ora no, SB 17/2/2015)
						 */
// 						if ($this->getStato() != '01') $riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
// 						else $riepilogoVociPreventivoGruppi .= "<td>&nbsp;</td>";

						$riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&tabella=Gruppi&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
						$riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
					}
					
					$riepilogoVociPreventivoGruppi .= "</tr>";
					$descrizioneVoceBreak = trim($row['descrizionevoce']);
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
						 * 
						 * (per ora no, SB 17/2/2015)
						 */
// 						if ($this->getStato() != '01') $riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
// 						else $riepilogoVociPreventivoGruppi .= "<td>&nbsp;</td>";

						$riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&tabella=Gruppi&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
						$riepilogoVociPreventivoGruppi .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
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
		return $replace;
	}		

	public function preparaTabellaVociCure($utility, $replace, $formCure, $titoloPagina) {
		
		if ($_SESSION['vociPreventivoCure']) {
		
			$totaleCure = 0;
			$riepilogoVociPreventivoCure = "";
			$replace['%riepilogoCureTab%'] = "<li><a href='#tabs-3'>%ml.cure%</a></li>";
				
			foreach ($_SESSION['vociPreventivoCure'] as $row) {
				
				$riepilogoVociPreventivoCure .= "<tr>";
				$riepilogoVociPreventivoCure .= "<td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td align='right'>&euro;" . number_format($row['prezzo'], 2, ',', '.') . "</td>";

				/**
				 * Se la funzione è un dettaglio inserisco le icone per modificare la voce
				 */
				if (strpos($titoloPagina, 'dettaglio')) {

					/**
					 * se il preventivo è "Accettato" non permette la modifica della voce
					 * 
					 * (per ora no, SB 17/2/2015)
					 * 
					 */
// 					if ($this->getStato() != '01') $riepilogoVociPreventivoCure .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
// 					else $riepilogoVociPreventivoCure .= "<td>&nbsp;</td>";
						
					$riepilogoVociPreventivoCure .= "<td id='icons'><a class='tooltip' href='../preventivo/modificaVocePreventivoFacade.class.php?modo=start&tabella=Cure&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
					$riepilogoVociPreventivoCure .= "<td id='icons'><a class='tooltip' href='../preventivo/ricercaNoteVocePreventivoFacade.class.php?modo=start&dente=" . $dente[1] . "&idvocepreventivo=" . $row['idvocepreventivo'] . "&idvocesottopreventivo=" . $row['idvocesottopreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Note'><span class='ui-icon ui-icon-comment'></span></li></a>";
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
		return $replace;
	}
}

?>