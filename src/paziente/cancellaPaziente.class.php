<?php

require_once 'gestionePaziente.abstract.class.php';

class cancellaPaziente extends gestionePazienteAbstract {
	
	public static $queryCancellaPaziente = "/paziente/cancellaPaziente.sql";	
	public static $azione = "../paziente/cancellaPazienteFacade.class.php?modo=go";

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
			$paziente->setCognomeDisable("readonly");
			$paziente->setCognomeStyle("color:#adadad; border:1px solid;");
			
			$paziente->setNome(trim($row["nome"]));
			$paziente->setNomeDisable("readonly");
			$paziente->setNomeStyle("color:#adadad; border:1px solid;");
			
			$paziente->setIndirizzo(trim($row["indirizzo"]));
			$paziente->setIndirizzoDisable("readonly");
			$paziente->setIndirizzoStyle("color:#adadad; border:1px solid;");
			
			$paziente->setCitta(trim($row["citta"]));
			$paziente->setCittaDisable("readonly");
			$paziente->setCittaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setCap(trim($row["cap"]));
			$paziente->setCapDisable("readonly");
			$paziente->setCapStyle("color:#adadad; border:1px solid;");
			
			$paziente->setProvincia(trim($row["provincia"]));
			$paziente->setProvinciaDisable("readonly");
			$paziente->setProvinciaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setEta(trim($row["eta"]));
			$paziente->setEtaDisable("readonly");
			$paziente->setEtaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setSesso(trim($row["sesso"]));		
			$paziente->setSessoDisable("disabled");
			
			$paziente->setTipo(trim($row["tipo"]));		
			$paziente->setTipoDisable("disabled");
			
			$paziente->setLuogoNascita(trim($row["luogonascita"]));
			$paziente->setLuogoNascitaDisable("readonly");
			$paziente->setLuogoNascitaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setDataNascita(trim($row["datanascita"]));
			$paziente->setDataNascitaDisable("readonly");
			$paziente->setDataNascitaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setCodiceFiscale(trim($row["codicefiscale"]));
			$paziente->setCodiceFiscaleDisable("readonly");
			$paziente->setCodiceFiscaleStyle("color:#adadad; border:1px solid;");
			
			$paziente->setPartitaIva(trim($row["partitaiva"]));
			$paziente->setPartitaIvaDisable("readonly");
			$paziente->setPartitaIvaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setTelefonoFisso(trim($row["telefonofisso"]));
			$paziente->setTelefonoFissoDisable("readonly");
			$paziente->setTelefonoFissoStyle("color:#adadad; border:1px solid;");
			
			$paziente->setTelefonoPortatile(trim($row["telefonoportatile"]));
			$paziente->setTelefonoPortatileDisable("readonly");
			$paziente->setTelefonoPortatileStyle("color:#adadad; border:1px solid;");
			
			$paziente->setEmail(trim($row["email"]));
			$paziente->setEmailDisable("readonly");
			$paziente->setEmailStyle("color:#adadad; border:1px solid;");
			
			$paziente->setDataInserimento(trim($row["datainserimento"]));			
			$paziente->setDataInserimentoStyle("color:#adadad; border:1px solid;");
			$paziente->setDataModifica(trim($row["datamodifica"]));
			$paziente->setDataModificaStyle("color:#adadad; border:1px solid;");
			
			$paziente->setListino(trim($row["idlistino"]));
			$paziente->setListinoDisable("disabled");
			
			$paziente->setMedico(trim($row["idmedico"]));
			$paziente->setMedicoDisable("disabled");
			
			$paziente->setLaboratorio(trim($row["idlaboratorio"]));
			$paziente->setLaboratorioDisable("disabled");			

			$paziente->setAzione(self::$azione . "&idPaziente=" . $this->getIdPaziente() . "&cognRic=" . $this->getCognomeRicerca());
			$paziente->setConfermaTip("%ml.confermaCancellazionePaziente%");
			$paziente->setCognomeRicerca($this->getCognomeRicerca());
 			$paziente->setTitoloPagina("%ml.cancellaPaziente%");
 			
			// set dei totali prelevati ---------------------------------
			$paziente->setTotaleVisiteIncorso($row['numvisite_incorso']);
			$paziente->setTotaleVisitePreventivate($row['numvisite_preventivate']);
			$paziente->setTotalePreventiviProposti($row['numpreventivi_proposti']);
			$paziente->setTotalePreventiviAccettati($row['numpreventivi_accettati']);
			$paziente->setTotaleCartelleAttive($row['numcartellecliniche_attive']);
			$paziente->setTotaleCartelleIncorso($row['numcartellecliniche_incorso']);
			$paziente->setTotaleCartelleChiuse($row['numcartellecliniche_chiuse']); 			
 			
			$paziente->setPaziente($paziente);		
			
			include($testata);
			$paziente->displayPagina();
			$paziente->displayTotali();
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

		$paziente->setAzione($this->getAzione() . "&idPaziente=" . $this->getIdPaziente() . "&cognRic=" . $this->getCognomeRicerca());
		$paziente->setIdPaziente($this->getIdPaziente());
		$paziente->setCognomeRicerca($this->getCognomeRicerca());
		$paziente->setTitoloPagina("%cancellaPaziente%");
		$paziente->setPaziente($paziente);
		
		if ($this->cancella($paziente)) {
			$ricercaPaziente = new ricercaPaziente();
			$ricercaPaziente->setMessaggio("%ml.canPazienteOk%");
			$ricercaPaziente->setCognomeRicerca($this->getCognomeRicerca());
			$ricercaPaziente->go();
		}
		else {
			include($testata);
			
			$paziente->displayPagina();
			$replace = array('%messaggio%' => '%ml.canPazienteKo%');
			
			$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);

			include($piede);
		}
	}

	private function cancella($paziente) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		

		// carica e ritaglia il comando sql da lanciare
		$replace = array(
			'%idpaziente%' => $paziente->getIdPaziente()
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaPaziente;
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
