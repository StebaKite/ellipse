<?php

require_once 'strumenti.abstract.class.php';

class vocelistino extends strumentiAbstract {

	public static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	public static $queryCreaVoceListino = "/impostazioni/creaVoceListino.sql";
	public static $queryLeggiVoce = "/impostazioni/ricercaIdVoce.sql";
	public static $queryLeggiListino = "/impostazioni/ricercaIdListino.sql";
	
	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);
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
			$this->inserisciDati($db, $utility, $row, self::$queryCreaVoceListino, $temp, $rows);
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
				
			if (trim($regola['colonna']) == "idvocelistino") {

				// risoluzione della chiave esterna sulla Voce
				$idVoce = $this->prelevaIdVoce($db, $utility, str_replace('"', '', $campiRecord[$regola['posizionevalore']]));
				$replace['%' . trim($regola['colonna']) . '%'] = $idVoce;
			}
			elseif (trim($regola['colonna']) == "idlistino") {

				// risoluzione della chiave esterna sul Listino
				$idListino = $this->prelevaIdListino($db, $utility, str_replace('"', '', $campiRecord[$regola['posizionevalore']]));
				$replace['%' . trim($regola['colonna']) . '%'] = $idListino;
				
			}
			else {
				$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
			}
		}

		$sqlTemplate = self::$root . $array['query'] . $insertTemplate;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);

		return $db->execSql($sql);
	}

	public function prelevaIdVoce($db, $utility, $codiceVoce) {

		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiVoce;

		$replace = array('%codice%' => $codiceVoce);

		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		$row = pg_fetch_all($result);
		return trim(stripslashes($row[0]['idvoce']));
	}

	public function prelevaIdListino($db, $utility, $codiceListino) {

		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiListino;

		$replace = array('%codice%' => $codiceListino);

		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		$row = pg_fetch_all($result);
		return trim(stripslashes($row[0]['idlistino']));
	}
}

?>