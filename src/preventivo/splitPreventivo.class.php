<?php

require_once 'preventivo.abstract.class.php';

class splitPreventivo extends preventivoAbstract {

	public static $azioneSplitPreventivo = "../paziente/splitPreventivoFacade.class.php?modo=go";

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
	
		require_once 'splitPreventivo.template.php';
		require_once 'utility.class.php';
	
		$splitPreventivoTemplate = new splitPreventivoTemplate();
		$this->preparaPagina($splitPreventivoTemplate);

		if ($this->inserisciSottoPreventivo()) {
			
			if ($this->ricercaVociPreventivoPrincipale($splitPreventivoTemplate) 
			and	$this->ricercaVociPreventivoSecondario($splitPreventivoTemplate)) {

					include(self::$testata);
					$splitPreventivoTemplate->displayFiltri();
					$splitPreventivoTemplate->displayRisultati();
					include(self::$piede);						
			}
		}		
		else {
			include(self::$testata);
			
			$splitPreventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaSottoPreventivoKo%');
			
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
			
			include(self::$piede);
		}
	}

	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'splitPreventivo.template.php';
		require_once 'utility.class.php';
		
		$splitPreventivoTemplate = new splitPreventivoTemplate();
		$this->preparaPagina($splitPreventivoTemplate);
		
		if ($this->ricercaVociPreventivoPrincipale($splitPreventivoTemplate)
		and	$this->ricercaVociPreventivoSecondario($splitPreventivoTemplate)) {

			include(self::$testata);
			$splitPreventivoTemplate->displayFiltri();
			$splitPreventivoTemplate->displayRisultati();
			include(self::$piede);
		}
	}
	
	public function ricercaVociPreventivoPrincipale($splitPreventivoTemplate) {
	
		require_once 'database.class.php';
	
		// carica il comando sql da lanciare
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociPreventivoPrincipale;
	
		$replace = array(
				'%idpreventivo%' => $this->getIdPreventivo(),
				'%idpaziente%' => $this->getIdpaziente()
		);
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$db = new database();
		$result = $db->getData($sql);
	
		$splitPreventivoTemplate->setNumeroVociPreventivoPrincipaleTrovate(pg_num_rows($result));
		$splitPreventivoTemplate->setVociPreventivoPrincipaleTrovate($result);
		return $result;
	}

	public function ricercaVociPreventivoSecondario($splitPreventivoTemplate) {
	
		require_once 'database.class.php';
	
		// carica il comando sql da lanciare
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociPreventivoSecondario;
	
		$replace = array(
				'%idpreventivo%' => $this->getIdPreventivo(),
				'%idsottopreventivo%' => $this->getIdSottoPreventivo(),
				'%idpaziente%' => $this->getIdpaziente()
		);
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$db = new database();
		$result = $db->getData($sql);
	
		$splitPreventivoTemplate->setNumeroVociPreventivoSecondarioTrovate(pg_num_rows($result));
		$splitPreventivoTemplate->setVociPreventivoSecondarioTrovate($result);
		return $result;
	}
	
	public function preparaPagina($splitPreventivoTemplate) {
	
		$splitPreventivoTemplate->setAzione(self::$azioneSplitPreventivo);
		$splitPreventivoTemplate->setTestoAzione("%ml.splitPreventivoTip%");
		$splitPreventivoTemplate->setTitoloPagina("%ml.splitPreventivo%");
	}
	
	public function inserisciSottoPreventivo() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->creaSottoPreventivo($db)) {
			$idSottoPreventivoUsato = $db->getLastIdUsed();
			$this->setIdSottoPreventivo($idSottoPreventivoUsato);
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}
	
?>