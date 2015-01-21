<?php

require_once 'gestionePaziente.abstract.class.php';

class creaPaziente extends gestionePazienteAbstract {

	public static $azione = "../paziente/creaPazienteFacade.class.php?modo=go";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	public function getAzione() {
		return self::$azione;
	}

	public function start() {

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
		$paziente->setAzione($this->getAzione());
		$paziente->setConfermaTip("%ml.confermaCreazionePaziente%");
		
		$paziente->setCognomeRicerca(ucwords($_POST["cognome"]));
		$paziente->setTitoloPagina("%ml.creaNuovoPaziente%");
		$paziente->setPaziente($paziente);		

		// Compone la pagina
		include($testata);
		$paziente->inizializzaPagina();
		$paziente->displayPagina();
		include($piede);

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
		$paziente->setListino($_POST["listino"]);
		$paziente->setMedico($_POST["medico"]);
		$paziente->setLaboratorio($_POST["laboratorio"]);

		$paziente->setTitoloPagina("%ml.creaNuovoPaziente%");

		$paziente->setPaziente($paziente);

		if ($paziente->controlliLogici()) {

			if ($this->inserisci($paziente)) {
				$ricercaPaziente = new ricercaPaziente();
				$ricercaPaziente->setMessaggio("%ml.creaPazienteOk%");
				$ricercaPaziente->setCognomeRicerca($this->getCognomeRicerca());
				$ricercaPaziente->go();
			}
			else {
				$paziente->inizializzaPagina();	
				include($testata);
				
				$paziente->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaPazienteKo%');
				
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
		
	private function inserisci($paziente) {

		require_once 'database.class.php';

		$esito = TRUE;

		$db = new database();

		$cognome = addslashes(ucwords(str_replace("'","''",trim($paziente->getCognome()))));
		$nome = addslashes(ucwords(str_replace("'","''",trim($paziente->getNome()))));
		$indirizzo = addslashes(ucwords(str_replace("'","''",trim($paziente->getIndirizzo())))); 
		$citta = addslashes(ucwords(str_replace("'","''",trim($paziente->getCitta()))));
		$cap = str_replace("'","''",trim($paziente->getCap()));
		$provincia = addslashes(ucwords(str_replace("'","''",trim($paziente->getProvincia()))));
		$eta = trim($paziente->getEta());
		$sesso = str_replace("'","''",trim($paziente->getSesso()));
		$tipo = str_replace("'","''",trim($paziente->getTipo()));
		$luogoNascita = addslashes(ucwords(str_replace("'","''",trim($paziente->getLuogoNascita()))));
		$dataNascita = trim($paziente->getDataNascita());
		$codiceFiscale = strtoupper(str_replace("'","''",trim($paziente->getCodiceFiscale())));
		$partitaIva = str_replace("'","''",trim($paziente->getPartitaIva()));
		$telefonoFisso = str_replace("'","''",trim($paziente->getTelefonoFisso()));
		$telefonoPortatile = str_replace("'","''",trim($paziente->getTelefonoPortatile()));
		$email = addslashes(str_replace("'","''",trim($paziente->getEmail())));
		$medico = trim($paziente->getMedico());
		$laboratorio = trim($paziente->getLaboratorio());
		$listino = trim($paziente->getListino());

		$sql = "INSERT INTO paziente.paziente VALUES (nextval('paziente.paziente_idpaziente_seq')," .
			"'$cognome','$nome','$tipo','$indirizzo','$citta','$cap','$provincia','$eta','$sesso','$luogoNascita','$dataNascita','$codiceFiscale'," .
			"'$partitaIva','$telefonoFisso','$telefonoPortatile','$email',current_date,null,'','$medico','$laboratorio','$listino')";
		
		$result = $db->getData($sql);
		error_log($sql);
			
		if (!$result) {
			$esito = FALSE;
		}

		return $esito;	
	}	
}

?>
