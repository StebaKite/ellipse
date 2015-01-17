<?php

require_once 'impostazioni.abstract.class.php';

class cancellaCategoria extends impostazioniAbstract {

	public static $azioneCancellaCategoria = "../impostazioni/cancellaCategoriaFacade.class.php?modo=go";

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/impostazioni:" . self::$root . "/ellipse/src/utility";
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
		require_once 'ricercaCategoria.class.php';
		require_once 'utility.class.php';
	
		$categoriaTemplate = new categoriaTemplate();
		$this->preparaPagina($categoriaTemplate);
	
		$utility = new utility();
	
		if ($this->cancella()) {
			$ricercaCategoria = new ricercaCategoria();
			$ricercaCategoria->setMessaggio('%ml.cancellaCategoriaOk%');
			$ricercaCategoria->start();
		}
		else {
			include(self::$testata);
	
			$categoriaTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaCategoriaKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
	
			include(self::$piede);
		}
	}
	
	public function preparaPagina($categoriaTemplate) {
	
		$categoriaTemplate->setAzione(self::$azioneCancellaCategoria);
		$categoriaTemplate->setTestoAzione("%ml.cancellaCategoriaTip%");
		$categoriaTemplate->setTitoloPagina("%ml.cancellaCategoria%");
		$categoriaTemplate->setCodiceCategoriaTip("%ml.codiceCategoriaTip%");
		$categoriaTemplate->setCodiceCategoriaDisable("disabled");
		$categoriaTemplate->setDescrizioneCategoriaTip("%ml.descrizioneCategoriaTip%");
		$categoriaTemplate->setDescrizioneCategoriaDisable("disabled");
	}

	private function cancella() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->cancellaCategoria($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}	
?>