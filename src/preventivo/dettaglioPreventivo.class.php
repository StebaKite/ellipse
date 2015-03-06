<?php

require_once 'preventivo.abstract.class.php';

class dettaglioPreventivo extends preventivoAbstract {

	public static $azioneAccettaPreventivo = "../preventivo/accettaPreventivoFacade.class.php?modo=start";
	public static $azioneRinunciaPreventivo = "../preventivo/rinunciaPreventivoFacade.class.php?modo=start";
	
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

	// ------------------------------------------------

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'dettaglioPreventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		$db = new database();
		
		$dettaglioPreventivoTemplate = new dettaglioPreventivoTemplate();
		$this->preparaPagina($dettaglioPreventivoTemplate, $db);

		if ($_SESSION['idPreventivo'] != "") {
			$this->prelevaVociPreventivoPrincipale($db, $dettaglioPreventivoTemplate);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$this->prelevaVociPreventivoSecondario($db, $dettaglioPreventivoTemplate);
		}
		
		// Compone la pagina
		include(self::$testata);
		$dettaglioPreventivoTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function preparaPagina($dettaglioPreventivoTemplate, $db) {

		$utility = new utility();
		
		$dettaglioPreventivoTemplate->setIntestazioneColonnaAzioni("<th colspan='2'>&nbsp;</th>");

		if ($_SESSION['idPreventivo'] != "") {
			$idPreventivo = $_SESSION['idPreventivo'];
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$idPreventivo = $_SESSION['idSottoPreventivo'];
		}
		
		/**
		 * Business Rule  : Visualizzazione del bottone RINUNCIA
		 * 
		 * La rinucia di un preventivo "Accettato" (01) è possibile solo se la cartella clinica si trova in stato "Attiva" (00)
		 */
		if (($_SESSION['stato'] == '01')
		and ($this->leggiStatoCartellaClinica($db, $utility, $idPreventivo, $_SESSION['idPaziente'])) == '00') {
			
			$dettaglioPreventivoTemplate->setAzionePreventivoLabelBottone('%ml.rinuncia%');
			$dettaglioPreventivoTemplate->setAzionePreventivo(self::$azioneRinunciaPreventivo);
			$dettaglioPreventivoTemplate->setAzionePreventivoTip('%ml.rinunciaPreventivoTip%');
		}
		else {
			/**
			 * Business Rule :  Visualizzazione del bottone ACCETTA
			 * 
			 * L'accettazione ricorsiva di un preventivo è consentita solo se la cartella clinica corrispondente è in 
			 * stato "Attiva" (00). Se è "In Corso" non è consentita l'accettazione dello stesso preventivo 
			 */
			if (($this->leggiStatoCartellaClinica($db, $utility, $idPreventivo, $_SESSION['idPaziente']) == '00') 
			or  ($this->leggiStatoCartellaClinica($db, $utility, $idPreventivo, $_SESSION['idPaziente']) == ''))  {
				$dettaglioPreventivoTemplate->setAzionePreventivoLabelBottone('%ml.accetta%');
				$dettaglioPreventivoTemplate->setAzionePreventivo(self::$azioneAccettaPreventivo);
				$dettaglioPreventivoTemplate->setAzionePreventivoTip('%ml.accettaPreventivoTip%');				
			}
			else {
				$dettaglioPreventivoTemplate->setAzionePreventivoLabelBottone('');
				$dettaglioPreventivoTemplate->setAzionePreventivo('');
				$dettaglioPreventivoTemplate->setAzionePreventivoTip('');				
			}
		}

		if ($_SESSION['idPreventivo'] != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.dettaglioPreventivoPrincipale%");
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.dettaglioPreventivoSecondario%");
		}
	}
}

?>