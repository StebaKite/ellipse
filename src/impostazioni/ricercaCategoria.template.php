<?php

require_once 'impostazioni.abstract.class.php';

class ricercaCategoriaTemplate  extends impostazioniAbstract {

	public static $filtri = "/impostazioni/ricercaCategoria.filtri.html";
	public static $risultatiTesta = "/impostazioni/ricercaCategoria.risultati.testata.html";
	public static $risultatiCorpo = "/impostazioni/ricercaCategoria.risultati.corpo.html";
	public static $risultatiPiede = "/impostazioni/ricercaCategoria.risultati.piede.html";

	public static $categorieTrovate;
	public static $numeroCategorieTrovate;
	public static $messaggio;

	// Setters -------------------------------------------------------------------

	public function setCategorieTrovate($categorieTrovate) {
		self::$categorieTrovate = $categorieTrovate;
	}
	public function setNumeroCategorieTrovate($numEle) {
		self::$numeroCategorieTrovate = $numEle;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}

	// Getters -------------------------------------------------------------------

	public function getCategorieTrovate() {
		return self::$categorieTrovate;
	}
	public function getNumeroCategorieTrovate() {
		return self::$numeroCategorieTrovate;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}

	//-----------------------------------------------------------------------------
	
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

	public function displayFiltri() {
	
		require_once 'utility.class.php';
	
		// Template ----------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
		$filtri = self::$root . $array['template'] . self::$filtri;
	
		echo $utility->getTemplate($filtri);
	}

	public function displayRisultati() {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		// Template ----------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$risultatiTesta = self::$root . $array['template'] . self::$risultatiTesta;
		$risultatiCorpo = self::$root . $array['template'] . self::$risultatiCorpo;
		$risultatiPiede = self::$root . $array['template'] . self::$risultatiPiede;
	
		// Gestione del messaggio -------------------
	
		$numCategorie = $this->getNumeroCategorieTrovate();
	
		if ($numCategorie > 0) {
				
			if ($numCategorie > 1) {
				$text1 = "%ml.trovate% "; $text2 = " %ml.categorie%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.categoria%";
			}
	
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
	
			$replace = array('%messaggio%' => $text0 . $text1 . $numCategorie . $text2);
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
	
			echo $utility->tailTemplate($template);
				
			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);
				
			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$categorieTrovate = $this->getCategorieTrovate();

			$rowcounter = 0;
			$oggi = date('d/m/Y');
				
			while ($row = pg_fetch_array($categorieTrovate)) {
					
				// evidenzia in bold la riga se è stata inserita o modificata oggi
				
				if ($rowcounter % 2 == 0) {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
						$class = "class='modifiedOn'";
					}
					else {
						$class = "class='on'";
					}
				}
				else {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
						$class = "class='modifiedOff'";
					}
					else {
						$class = "class=''";
					}
				}

				// BOTTONE CANCELLA -----------------------------------------------
				// nasconde il bottone cancella categoria se non contiene voci
				
				$bottoneCancella = "<a class='tooltip' href='cancellaCategoriaFacade.class.php?modo=start&idCategoria=" . stripslashes($row['idcategoria']) . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";
				
				if ($row['numvoci'] > 0)  $bottoneCancella = "";
				
				$replace = array(
						'%class%' => $class,
						'%idcategoria%' => trim(stripslashes($row['idcategoria'])),
						'%codicecategoria%' => trim(stripslashes($row['codicecategoria'])),
						'%descrizionecategoria%' => trim(stripslashes($row['descrizionecategoria'])),
						'%bottoneCancella%' => $bottoneCancella
				);

				++$rowcounter;
				
				$riga = $templateRiga;
				echo $utility->tailFile($riga, $replace);
			}
		}
		else {
	
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
	
			$replace = array('%messaggio%' => $text0 . '%ml.norisultati%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
	
			echo $utility->tailTemplate($template);	
		}
		echo $utility->getTemplate($risultatiPiede);
	}
}
	
?>