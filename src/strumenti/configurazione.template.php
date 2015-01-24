<?php

require_once 'strumenti.abstract.class.php';

class configurazioneTemplate extends strumentiAbstract {

	public static $pagina = "/strumenti/configurazione.form.html";
	public static $sourceFolder = "/ellipse/src/strumenti/";
	public static $fileFolder = "/ellipse/db/files/";
	
	//-----------------------------------------------------------------------------
	
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
	
	// template ------------------------------------------------
	
	public function inizializzaPagina() {
		
		$this->setProgressivo("");
		$this->setClasse("");
		$this->setFilepath("/ellipse/db/files/<nomefile.csv>");
		$this->setStatoDaeseguire("checked");
		
	}
	
	public function controlliLogici() {

		$esito = TRUE;
		
		// controllo esistenza classe
		$fileClass = self::$root . self::$sourceFolder . trim($this->getClasse()) . '.class.php';
				
		if (file_exists($fileClass)) {
			require_once trim($this->getClasse()) . '.class.php';				
			if (!class_exists(trim($this->getClasse()))) {
				$esito = FALSE;
				$this->setClasseStyle("border-color:#ff0000; border-width:2px;");
				$this->setClasseTip("%ml.classeEsistente%");
			}
		}
		else {
			$esito = FALSE;
			$this->setClasseStyle("border-color:#ff0000; border-width:2px;");
			$this->setClasseTip("%ml.fileClasseEsistente%");
		}

		// controllo esistenza file dati
		$fileDati = self::$root . trim($this->getFilepath());		
		
		if (!file_exists($fileDati)) {
			$esito = FALSE;
			$this->setFilepathStyle("border-color:#ff0000; border-width:2px;");
			$this->setFilePathTip("%ml.fileDatiEsistente%");
		}		
		return $esito;
	}

	public function displayPagina() {

		// Template --------------------------------------------------------------
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$form = self::$root . $array['template'] . self::$pagina;
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azione%' => $this->getAzione(),
				'%testoAzione%' => $this->getTestoAzione(),
				'%statoEseguitoChecked%' => $this->getStatoEseguito(),
				'%statoDaeseguireChecked%' => $this->getStatoDaeseguire(),
				'%statoDisable%' => $this->getStatoDisable(),
				'%idguida%' => $this->getIdguida(),				
				'%progressivo%' => $this->getProgressivo(),
				'%progressivoDisable%' => $this->getProgressivoDisable(),		
				'%classe%' => $this->getClasse(),
				'%classeDisable%' => $this->getClasseDisable(),
				'%filepath%' => $this->getFilepath(),
				'%filepathDisable%' => $this->getFilepathDisable(),
				'%progressivoTip%' => $this->getProgressivoTip(),
				'%classeTip%' => $this->getClasseTip(),
				'%classeStyle%' => $this->getClasseStyle(),
				'%filepathTip%' => $this->getFilepathTip(),	
				'%filepathStyle%' => $this->getFilepathStyle()	
		);

		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
		
	}	
}	
	
?>