<?php

require_once 'strumenti.abstract.class.php';

class paziente extends strumentiAbstract {

	public static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	public static $queryCreaPaziente = "/paziente/creaPaziente.sql";

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
			$this->inserisciDati($db, $utility, $row, self::$queryCreaPaziente, $temp, $rows);
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	/**
	 * @override 
	 */
	public function componiInserimento($db, $utility, $insertTemplate, $record, $rows) {
	
		$array = $utility->getConfig();
		$campiRecord = explode(";",$record);
		$replace = array();
	
		foreach($rows as $regola) {
	
			if (trim($regola['colonna']) == "tipo") {	
				$replace['%' . trim($regola['colonna']) . '%'] = 'D';
			}
			elseif (trim($regola['colonna']) == "sesso") {
				$replace['%' . trim($regola['colonna']) . '%'] = 'M';	
			}
			elseif (trim($regola['colonna']) == "cap") {
				if ($campiRecord[$regola['posizionevalore']] == null) {
					$replace['%' . trim($regola['colonna']) . '%'] = '99999';
				}
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "datanascita") {
				if ($campiRecord[$regola['posizionevalore']] == null) {
					$replace['%' . trim($regola['colonna']) . '%'] = '01/01/0001';
				}	
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "luogonascita") {
				if ($campiRecord[$regola['posizionevalore']] == null) {
					$replace['%' . trim($regola['colonna']) . '%'] = null;
				}	
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "provincia") {
				if ($campiRecord[$regola['posizionevalore']] == null) {
					$replace['%' . trim($regola['colonna']) . '%'] = 'XX';
				}	
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "partitaiva") {
				if ($campiRecord[$regola['posizionevalore']] == '""') {
					$replace['%' . trim($regola['colonna']) . '%'] = null;
				}	
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "telefonoportatile") {
				if ($campiRecord[$regola['posizionevalore']] == null) {
					$replace['%' . trim($regola['colonna']) . '%'] = null;
				}	
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "email") {
				if ($campiRecord[$regola['posizionevalore']] == null) {
					$replace['%' . trim($regola['colonna']) . '%'] = null;
				}	
				else {
					$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
				}
			}
			elseif (trim($regola['colonna']) == "idmedico") {
				$replace['%' . trim($regola['colonna']) . '%'] = 1;
			}
			elseif (trim($regola['colonna']) == "idlaboratorio") {
				$replace['%' . trim($regola['colonna']) . '%'] = 1;
			}
			elseif (trim($regola['colonna']) == "idlistino") {
				$replace['%' . trim($regola['colonna']) . '%'] = 1;
			}
			else {
				$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
			}
		}
	
		$sqlTemplate = self::$root . $array['query'] . $insertTemplate;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
	
		return $db->execSql($sql);
	}	
}	
	
?>