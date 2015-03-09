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
		
		if ($_SESSION['idPreventivo'] != "") {

			if ($this->cancellaPreventivoPrincipale($db, $utility, $_SESSION['idPaziente'], $_SESSION['idPreventivo'])) {
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
		elseif ($_SESSION['idSottoPreventivo'] != "") {

			if ($this->cancellaPreventivoSecondario($db, $utility, $_SESSION['idPaziente'], $_SESSION['idPreventivoPrincipale'], $_SESSION['idSottoPreventivo'])) {
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
	
		if ($_SESSION['idPreventivo'] != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.cancellaPreventivoPrincipale%");
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.cancellaPreventivoSecondario%");
		}
	}
}
	
?>