<?php

require_once 'preventivo.abstract.class.php';

class cancellaPreventivo extends preventivoAbstract {

	public static $azioneCancellaPreventivo = "../preventivo/cancellaPreventivoFacade.class.php?modo=go";

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

		$dettaglioPreventivoTemplate = new dettaglioPreventivoTemplate();
		$this->preparaPagina($dettaglioPreventivoTemplate);

		$db = new database();

		if ($this->getIdpreventivo() != "") {
			$this->prelevaVociPreventivoPrincipale($db, $dettaglioPreventivoTemplate);
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$this->prelevaVociPreventivoSecondario($db, $dettaglioPreventivoTemplate);
		}

		// Compone la pagina
		include(self::$testata);
		$dettaglioPreventivoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {

		require_once 'dettaglioPreventivo.template.php';
		require_once 'ricercaPreventivo.class.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		// Template
		$db = new database();

		$utility = new utility();
		$array = $utility->getConfig();

		$dettaglioPreventivoTemplate = new dettaglioPreventivoTemplate();
		$this->preparaPagina($dettaglioPreventivoTemplate);
		
		if ($this->getIdPreventivo() != "") {

			if ($this->cancellaPreventivoPrincipale($db, $utility, $this->getIdPaziente(), $this->getIdPreventivo())) {
				$ricercaPreventivo = new ricercaPreventivo();
				$ricercaPreventivo->setMessaggio('%ml.canPreventivoOk%');
				$ricercaPreventivo->start();
			}
			else {
				include(self::$testata);
				$dettaglioPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.canPreventivoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				include(self::$piede);
			}				
		}	
		elseif ($this->getIdSottoPreventivo() != "") {

			if ($this->cancellaPreventivoSecondario($db, $utility, $this->getIdPaziente(), $this->getIdPreventivoPrincipale(), $this->getIdSottoPreventivo())) {
				$ricercaPreventivo = new ricercaPreventivo();
				$ricercaPreventivo->setMessaggio('%ml.canPreventivoOk%');
				$ricercaPreventivo->start();
			}
			else {
				include(self::$testata);
				$dettaglioPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.canPreventivoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				include(self::$piede);
			}				
		}	
	}	

	public function cancellaPreventivoPrincipale($db, $utility, $idPaziente, $idPreventivo) {
		
		$array = $utility->getConfig();
		
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		
		$db = new database();
		$result = $db->getData($sql);

		return $result;		
	}

	public function cancellaPreventivoSecondario($db, $utility, $idPaziente, $idPreventivo, $idSottoPreventivo) {

		$array = $utility->getConfig();
		
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $idSottoPreventivo,
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		
		$db = new database();
		$result = $db->getData($sql);
		
		return $result;
		
	}
	
	
	public function preparaPagina($dettaglioPreventivoTemplate) {

		$dettaglioPreventivoTemplate->setIntestazioneColonnaAzioni("");
		
		$dettaglioPreventivoTemplate->setAzionePreventivoLabelBottone('%ml.conferma%');
		$dettaglioPreventivoTemplate->setAzionePreventivo(self::$azioneCancellaPreventivo);
		$dettaglioPreventivoTemplate->setAzionePreventivoTip('%ml.cancellaPreventivoTip%');
	
		if ($this->getIdpreventivo() != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.cancellaPreventivoPrincipale%");
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.cancellaPreventivoSecondario%");
		}
	}
}
	
?>