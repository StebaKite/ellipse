<?php

require_once 'gestionePaziente.abstract.class.php';

class modificaPaziente extends gestionePazienteAbstract {
	
	public static $queryModificaPaziente = "/paziente/modificaPaziente.sql";	
	public static $azione = "../paziente/modificaPazienteFacade.class.php?modo=go";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function start() {
		
		require_once 'paziente.template.php';
		require_once 'database.class.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		

		// carica e ritaglia il comando sql da lanciare
		$replace = array('%idpaziente%' => self::$idPaziente);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaIdPaziente;

		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		
		// Lettura del Paziente

		$db = new database();
		$result =	 $db->getData($sql);
		error_log($sql);

		$paziente = new paziente();

		if ($result) {

			$row = pg_fetch_array($result);
			
			$paziente = new paziente();

			$paziente->setIdPaziente(trim($row['idpaziente']));
			$paziente->setCognome(trim($row["cognome"]));
			$paziente->setNome(trim($row["nome"]));
			$paziente->setIndirizzo(trim($row["indirizzo"]));
			$paziente->setCitta(trim($row["citta"]));
			$paziente->setCap(trim($row["cap"]));
			$paziente->setProvincia(trim($row["provincia"]));
			$paziente->setEta(trim($row["eta"]));
			$paziente->setSesso(trim($row["sesso"]));
			$paziente->setTipo(trim($row["tipo"]));
			$paziente->setLuogoNascita(trim($row["luogonascita"]));
			$paziente->setDataNascita(trim($row["datanascita"]));
			$paziente->setCodiceFiscale(trim($row["codicefiscale"]));
			$paziente->setPartitaIva(trim($row["partitaiva"]));
			$paziente->setTelefonoFisso(trim($row["telefonofisso"]));
			$paziente->setTelefonoPortatile(trim($row["telefonoportatile"]));
			$paziente->setEmail(trim($row["email"]));
			$paziente->setDataInserimento(trim($row["datainserimento"]));
			$paziente->setDataInserimentoStyle("color:#adadad; border:1px solid;");
			$paziente->setDataModifica(trim($row["datamodifica"]));
			$paziente->setDataModificaStyle("color:#adadad; border:1px solid;");
			$paziente->setListino(trim($row["idlistino"]));
			$paziente->setMedico(trim($row["idmedico"]));
			$paziente->setLaboratorio(trim($row["idlaboratorio"]));

			$paziente->setAzione(self::$azione . "&idPaziente=" . $this->getIdPaziente() . "&cognRic=" . $this->getCognomeRicerca());
			$paziente->setCognomeRicerca($this->getCognomeRicerca());
			$paziente->setTitoloPagina("%ml.modificaPaziente%");
			$paziente->setPaziente($paziente);		
			
			include($testata);
			$paziente->displayPagina();
			include($piede);
		}
		else {
			$paziente->inizializzaPagina();	
			include($testata);
			$paziente->displayPagina();
			$replace = array('%messaggio%' => '%ml.readPazienteKo%');
			echo $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);
			include($piede);			
		}
	}

	public function go() {

		require_once 'ricercaPaziente.class.php';
		require_once 'paziente.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$paziente = new paziente();

		$paziente->setCognome($_POST["cognome"]);
		$paziente->setNome($_POST["nome"]);
		$paziente->setIndirizzo($_POST["indirizzo"]);
		$paziente->setCitta($_POST["citta"]);
		$paziente->setCap($_POST["cap"]);
		$paziente->setProvincia($_POST["provincia"]);
		$paziente->setEta($_POST["eta"]);
		$paziente->setSesso($_POST["sesso"]);		
		$paziente->setTipo($_POST["tipo"]);		
		$paziente->setLuogoNascita($_POST["luogonascita"]);
		$paziente->setDataNascita($_POST["datanascita"]);
		$paziente->setCodiceFiscale($_POST["codfiscale"]);
		$paziente->setPartitaIva($_POST["partitaiva"]);
		$paziente->setTelefonoFisso($_POST["telefonofisso"]);
		$paziente->setTelefonoPortatile($_POST["telefonoportatile"]);
		$paziente->setEmail($_POST["email"]);
		$paziente->setDataInserimento($_POST["datainserimento"]);
		$paziente->setListino($_POST["listino"]);
		$paziente->setMedico($_POST["medico"]);
		$paziente->setLaboratorio($_POST["laboratorio"]);

		$paziente->setAzione($this->getAzione() . "&idPaziente=" . $this->getIdPaziente() . "&cognRic=" . $this->getCognomeRicerca());
		$paziente->setIdPaziente($this->getIdPaziente());
		$paziente->setCognomeRicerca($this->getCognomeRicerca());
		$paziente->setTitoloPagina("%modificaPaziente%");
		$paziente->setPaziente($paziente);
		
		if ($paziente->controlliLogici()) {

			if ($this->modifica($paziente)) {
				$ricercaPaziente = new ricercaPaziente();
				$ricercaPaziente->setMessaggio("%ml.modPazienteOk%");
				$ricercaPaziente->setCognomeRicerca($this->getCognomeRicerca());
				$ricercaPaziente->go();
			}
			else {
				include($testata);
				
				$paziente->displayPagina();
				$replace = array('%messaggio%' => '%ml.modPazienteKo%');
				
				$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);			
				echo $utility->tailTemplate($template);

				include($piede);
			}
		}
		else {
			include($testata);
			$paziente->displayPagina();
			include($piede);
		} 
	}

	private function modifica($paziente) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		

		// carica e ritaglia il comando sql da lanciare
		$replace = array(
			'%idPaziente%' => $paziente->getIdPaziente(),
			'%cognome%' => ucwords(str_replace("'","''",trim($paziente->getCognome()))),
			'%nome%' => ucwords(str_replace("'","''",trim($paziente->getNome()))),
			'%indirizzo%' => ucwords(str_replace("'","''",trim($paziente->getIndirizzo()))),
			'%citta%' => ucwords(str_replace("'","''",trim($paziente->getCitta()))),
			'%cap%' => str_replace("'","''",trim($paziente->getCap())),
			'%provincia%' => ucwords(str_replace("'","''",trim($paziente->getProvincia()))),
			'%eta%' => trim($paziente->getEta()),
			'%sesso%' => str_replace("'","''",trim($paziente->getSesso())),
			'%tipo%' => str_replace("'","''",trim($paziente->getTipo())),
			'%luogoNascita%' => ucwords(str_replace("'","''",trim($paziente->getLuogoNascita()))),
			'%dataNascita%' => trim($paziente->getDataNascita()),
			'%codiceFiscale%' => strtoupper(str_replace("'","''",trim($paziente->getCodiceFiscale()))),
			'%partitaIva%' => str_replace("'","''",trim($paziente->getPartitaIva())),
			'%telefonoFisso%' => str_replace("'","''",trim($paziente->getTelefonoFisso())),
			'%telefonoPortatile%' => str_replace("'","''",trim($paziente->getTelefonoPortatile())),
			'%email%' => str_replace("'","''",trim($paziente->getEmail())),
			'%dataInserimento%' => trim($paziente->getDataInserimento()),
			'%medico%' => trim($paziente->getMedico()),
			'%laboratorio%' => trim($paziente->getLaboratorio()),
			'%listino%' => trim($paziente->getListino())
			);

		$sqlTemplate = self::$root . $array['query'] . self::$queryModificaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);

		$esito = TRUE;

		$db = new database();		
		$result = $db->getData($sql);
		error_log($sql);
			
		if (!$result) {
			$esito = FALSE;
		}
		return $esito;	
	}
}
?>
