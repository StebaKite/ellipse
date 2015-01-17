<?php

require_once 'impostazioni.abstract.class.php';

class modificaCategoria extends impostazioniAbstract {

	public static $azioneModificaCategoria = "../impostazioni/modificaCategoriaFacade.class.php?modo=go";

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);

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

		require_once 'categoria.template.php';
		require_once 'utility.class.php';
		
		$categoriaTemplate = new categoriaTemplate();
		$this->preparaPagina($categoriaTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$categoriaTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
	
		require_once 'categoria.template.php';
		require_once 'utility.class.php';
	
		$categoriaTemplate = new categoriaTemplate();
		$this->preparaPagina($categoriaTemplate);
	
		if ($categoriaTemplate->controlliLogici()) {
			$utility = new utility();
	
			if ($this->modifica()) {
				include(self::$testata);
	
				$categoriaTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaCategoriaOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
	
				include(self::$piede);
			}
			else {
				include(self::$testata);
	
				$categoriaTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaCategoriaKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
	
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$categoriaTemplate->displayPagina();
			include(self::$piede);
		}
	}

	public function preparaPagina($categoriaTemplate) {
	
		$categoriaTemplate->setAzione(self::$azioneModificaCategoria);
		$categoriaTemplate->setTestoAzione("%ml.modificaCategoriaTip%");
		$categoriaTemplate->setTitoloPagina("%ml.modificaCategoria%");
		$categoriaTemplate->setCodiceCategoriaTip("%ml.codiceCategoriaTip%");
		$categoriaTemplate->setDescrizioneCategoriaTip("%ml.descrizioneCategoriaTip%");
	}
	
	private function modifica() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaCategoria($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
	
	
	
}
		
?>