<?php

require_once 'impostazioni.abstract.class.php';

class creaCategoria extends impostazioniAbstract {

	public static $azioneCreaCategoria = "../impostazioni/creaCategoriaFacade.class.php?modo=go";

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

		require_once 'categoria.template.php';
		require_once 'utility.class.php';
		
		$categoriaTemplate = new categoriaTemplate();
		$this->preparaPagina($categoriaTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$categoriaTemplate->inizializzaPagina();
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
		
		if ($categoriaTemplate->controlliLogici()) {
			$utility = new utility();
		
			if ($this->inserisci()) {
				$ricercaCategoria = new ricercaCategoria();
				$ricercaCategoria->setMessaggio('%ml.creaCategoriaOk%');
				$ricercaCategoria->start();
			}
			else {
				include(self::$testata);
		
				$categoriaTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaCategoriaKo%');
		
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
		
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$configurazioneTemplate->setStatoDaeseguire("checked");
			$configurazioneTemplate->displayPagina();
			include(self::$piede);
		}
	}	

	public function preparaPagina($categoriaTemplate) {
	
		$categoriaTemplate->setAzione(self::$azioneCreaCategoria);
		$categoriaTemplate->setTestoAzione("%ml.creaCategoriaTip%");
		$categoriaTemplate->setTitoloPagina("%ml.creaCategoria%");
		$categoriaTemplate->setCodiceCategoriaTip("%ml.codiceCategoriaTip%");
		$categoriaTemplate->setDescrizioneCategoriaTip("%ml.descrizioneCategoriaTip%");
	}

	private function inserisci() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->creaCategoria($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}
	
?>