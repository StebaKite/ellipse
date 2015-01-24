<?php

require_once 'strumenti.abstract.class.php';

class voce extends strumentiAbstract {

	public static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	public static $queryCreaVoce = "/impostazioni/creaVoce.sql";
	public static $queryLeggiCategoria = "/impostazioni/ricercaIdCategoria.sql";
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function start($db, $utility, $row) {

		$mess = $this->getMessaggi();
		array_push($mess, "<br>" . "<<<<<<< Start della classe >>>>>>> " . "<br>");
		$this->setMessaggi($mess);

		$rows = $this->caricaRegoleMapping($db, $utility, $row);
		$temp = $this->caricaFileDati($row);

		/*
		 * se l'inserimento non prevede il recupero di chiavi esterne è sufficiente chiamare il metodo
		 * inserisciDati()
		 *
		 * se l'inserimento prevede il recupero di chiavi esterne in questa classe devi fare l'override
		 * del metodo componiInserimento()
		 *
		*/
		if ($temp != "") {
			$this->inserisciDati($db, $utility, $row, self::$queryCreaVoce, $temp, $rows);
			return TRUE;
		}
		else {
			return FALSE;
		}		
	}
	
	public function componiInserimento($db, $utility, $insertTemplate, $record, $rows) {
	
		$array = $utility->getConfig();
		$campiRecord = explode(";",$record);
		$replace = array();
	
		foreach($rows as $regola) {
			
			if (trim($regola['colonna']) == "idcategoria") {

				// risoluzione della chiave esterna sulla Categoria
				$idCategoria = $this->prelevaIdCategoria($db, $utility, str_replace('"', '', $campiRecord[$regola['posizionevalore']]));
				$replace['%' . trim($regola['colonna']) . '%'] = $idCategoria;				
			}
			else {
				$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
			}
		}
	
		$sqlTemplate = self::$root . $array['query'] . $insertTemplate;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
	
		return $db->execSql($sql);
	}
	
	public function prelevaIdCategoria($db, $utility, $codiceCategoria) {
		
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiCategoria;
		
		$replace = array('%codicecategoria%' => $codiceCategoria);
		
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		$row = pg_fetch_all($result);
		return trim(stripslashes($row[0]['idcategoria']));
	}
}
?>