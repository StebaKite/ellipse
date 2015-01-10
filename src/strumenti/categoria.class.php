<?php

require_once 'strumenti.abstract.class.php';

class categoria extends strumentiAbstract {
	
	private static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	private static $queryCreaCategoria = "/paziente/creaCategoria.sql";
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);	
	}
	
	public function start($db, $utility, $mess, $row) {

		array_push($mess, "<br>" . "<<<<<<< Start della classe >>>>>>> " . "<br>");
		
		
		// carico le regole di mapping di questo file ----------------------------------------------
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRegoleConfigurazioni;
		
		$replace = array('%idguida%' => $row['idguida']);
		
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);
		
		array_push($mess, "Carico le regole di mapping ..." . "<br>");
		foreach($rows as $regola) {
			array_push($mess, implode(" , ", $regola) . "<br>");
		}		

		
		// carico il file ---------------------------------------------------------------------------
		
		array_push($mess, "Carico il file ..." . "<br>");
		$file = self::$root . $row['filepath'];
		if (file_exists($file)) {
			$temp = file($file);
		}
		else {
			array_push($mess, "Attenzione! Il file " . $file . " non esiste, salto questa importazione e proseguo" . "<br>");
		}

		
		// faccio le insert usando il template sql --------------------------------------------------

		$db->beginTransaction();
		
		array_push($mess, "Carico i dati nella tabella '" . $row['classe'] . "' ...<br>");
		
		for($i = 0; $i < count($temp); $i++) {

			$array = $utility->getConfig();

			$campiRecord = explode(";",$temp[$i]);
			$replace = array();
			foreach($rows as $regola) {
				$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]); 
			}
			
			$sqlTemplate = self::$root . $array['query'] . self::$queryCreaCategoria;
			$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
			$result = $db->execSql($sql);
			if (!$result) break;
		}
		
		if ($i >= count($temp)) {
			$db->commitTransaction();
			array_push($mess, "ok, caricate " . $i . " righe ...<br>");
		}
		else {
			$db->rollbackTransaction();
			array_push($mess, "Errore SQL riscontrato durante l'INSERT dei dati, salto il caricamento e proseguo <br>");
		}
		
		return $mess;
	}
}

?>