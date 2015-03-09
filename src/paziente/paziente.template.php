<?php

require_once 'gestionePaziente.abstract.class.php';

class paziente extends gestionePazienteAbstract {
	
	private static $pagina = "/paziente/paziente.form.html";
	private static $totaliVisita = "/paziente/dettaglioPaziente.totali.visita.html";
	private static $totaliPreventivo = "/paziente/dettaglioPaziente.totali.preventivo.html";
	private static $totaliCartelle = "/paziente/dettaglioPaziente.totali.cartelle.html";

	private static $cognome;
	private static $cognomeStyle;	
	private static $cognomeTip;	
	private static $cognomeDisable;

	private static $nome;
	private static $nomeStyle;	
	private static $nomeTip;
	private static $nomeDisable;

	private static $indirizzo;
	private static $indirizzoStyle;	
	private static $indirizzoTip;
	private static $indirizzoDisable;

	private static $citta;
	private static $cittaStyle;	
	private static $cittaTip;
	private static $cittaDisable;

	private static $provincia;
	private static $provinciaStyle;	
	private static $provinciaTip;
	private static $provinciaDisable;

	private static $cap;
	private static $capStyle;	
	private static $capTip;
	private static $capDisable;

	private static $luogoNascita;
	private static $luogoNascitaStyle;	
	private static $luogoNascitaTip;
	private static $luogoNascitaDisable;

	private static $dataNascita;
	private static $dataNascitaStyle;	
	private static $dataNascitaTip;
	private static $dataNascitaDisable;

	private static $sesso;
	private static $sessoStyle;	
	private static $sessoTip;
	private static $sessoDisable;

	private static $tipo;
	private static $tipoStyle;	
	private static $tipoTip;
	private static $tipoDisable;

	private static $codiceFiscale;
	private static $codiceFiscaleStyle;	
	private static $codiceFiscaleTip;
	private static $codiceFiscaleDisable;

	private static $partitaIva;
	private static $partitaIvaStyle;	
	private static $partitaIvaTip;
	private static $partitaIvaDisable;

	private static $telefonoFisso;
	private static $telefonoFissoStyle;	
	private static $telefonoFissoTip;
	private static $telefonoFissoDisable;

	private static $telefonoPortatile;
	private static $telefonoPortatileStyle;	
	private static $telefonoPortatileTip;
	private static $telefonoPortatileDisable;

	private static $email;
	private static $emailStyle;	
	private static $emailTip;
	private static $emailDisable;

	private static $dataInserimento;
	private static $dataInserimentoStyle;	
	private static $dataInserimentoTip;
	private static $dataInserimentoDisable;

	private static $dataModifica;
	private static $dataModificaStyle;	
	private static $dataModificaTip;
	private static $dataModificaDisable;

	private static $listino;
	private static $listinoStyle;
	private static $listinoTip;
	private static $listinoDisable;
	
	private static $medico;
	private static $medicoStyle;
	private static $medicoTip;
	private static $medicoDisable;
	
	private static $laboratorio;
	private static $laboratorioStyle;
	private static $laboratorioTip;
	private static $laboratorioDisable;

	private static $totaleVisiteIncorso;
	private static $totaleVisitePreventivate;
	private static $totalePreventiviProposti;
	private static $totalePreventiviAccettati;
	private static $totaleCartelleAttive;
	private static $totaleCartelleIncorso;
	private static $totaleCartelleChiuse;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters --------------------------------------------------------------------
	
	public function setPaziente($paziente) {
		self::$paziente = $paziente;
	}
	//--------------------------------------------------
	
	public function setCognome($cognome) {
		self::$cognome = $cognome;	
	}
	public function setCognomeStyle($style) {
		self::$cognomeStyle = $style;
	}
	public function setCognomeTip($tip) {
		self::$cognomeTip = $tip;
	}
	public function setCognomeDisable($disable) {
		self::$cognomeDisable = $disable;
	}
	//--------------------------------------------------
	
	public function setNome($nome) {
		self::$nome = $nome;	
	}	
	public function setNomeStyle($style) {
		self::$nomeStyle = $style;
	}
	public function setNomeTip($tip) {
		self::$nomeTip = $tip;
	}
	public function setNomeDisable($disable) {
		self::$nomeDisable = $disable;
	}
	//--------------------------------------------------
	
	public function setIndirizzo($indirizzo) {
		self::$indirizzo = $indirizzo;	
	}	
	public function setIndirizzoStyle($style) {
		self::$indirizzoStyle = $style;
	}
	public function setIndirizzoTip($tip) {
		self::$indirizzoTip = $tip;
	}
	public function setIndirizzoDisable($disable) {
		self::$indirizzoDisable = $disable;
	}
	//--------------------------------------------------
	
	public function setCitta($citta) {
		self::$citta = $citta;	
	}	
	public function setCittaStyle($style) {
		self::$cittaStyle = $style;
	}
	public function setCittaTip($tip) {
		self::$cittaTip = $tip;
	}
	public function setCittaDisable($disable) {
		self::$cittaDisable = $disable;
	}
	//-----------------------
	
	public function setProvincia($provincia) {
		self::$provincia = $provincia;	
	}	
	public function setProvinciaStyle($style) {
		self::$provinciaStyle = $style;
	}
	public function setProvinciaTip($tip) {
		self::$provinciaTip = $tip;
	}
	public function setProvinciaDisable($disable) {
		self::$provinciaDisable = $disable;
	}
	//-----------------------
	
	public function setCap($cap) {
		self::$cap = $cap;	
	}	
	public function setCapStyle($style) {
		self::$capStyle = $style;
	}
	public function setCapTip($tip) {
		self::$capTip = $tip;
	}
	public function setCapDisable($disable) {
		self::$capDisable = $disable;
	}

	//-----------------------
	
	public function setLuogoNascita($luogoNascita) {
		self::$luogoNascita = $luogoNascita;	
	}	
	public function setLuogoNascitaStyle($style) {
		self::$luogoNascitaStyle = $style;
	}
	public function setLuogoNascitaTip($tip) {
		self::$luogoNascitaTip = $tip;
	}
	public function setLuogoNascitaDisable($disable) {
		self::$luogoNascitaDisable = $disable;
	}
	//-----------------------
	
	public function setDataNascita($dataNascita) {
		self::$dataNascita = $dataNascita;	
	}	
	public function setDataNascitaStyle($style) {
		self::$dataNascitaStyle = $style;
	}
	public function setDataNascitaTip($tip) {
		self::$dataNascitaTip = $tip;
	}
	public function setDataNascitaDisable($disable) {
		self::$dataNascitaDisable = $disable;
	}
	//-----------------------
	
	public function setSesso($sesso) {
		self::$sesso = $sesso;	
	}	
	public function setSessoStyle($style) {
		self::$sessoStyle = $style;
	}
	public function setSessoTip($tip) {
		self::$sessoTip = $tip;
	}
	public function setSessoDisable($disable) {
		self::$sessoDisable = $disable;
	}
	//-----------------------
	
	public function setTipo($tipo) {
		self::$tipo = $tipo;	
	}	
	public function setTipoStyle($style) {
		self::$tipoStyle = $style;
	}
	public function setTipoTip($tip) {
		self::$tipoTip = $tip;
	}
	public function setTipoDisable($disable) {
		self::$tipoDisable = $disable;
	}
	//-----------------------
	
	public function setCodiceFiscale($codiceFiscale) {
		self::$codiceFiscale = $codiceFiscale;	
	}	
	public function setCodiceFiscaleStyle($style) {
		self::$codiceFiscaleStyle = $style;
	}
	public function setCodiceFiscaleTip($tip) {
		self::$codiceFiscaleTip = $tip;
	}
	public function setCodiceFiscaleDisable($disable) {
		self::$codiceFiscaleDisable = $disable;
	}
	//-----------------------
	
	public function setPartitaIva($partitaIva) {
		self::$partitaIva = $partitaIva;	
	}	
	public function setPartitaIvaStyle($style) {
		self::$partitaIvaStyle = $style;
	}
	public function setPartitaIvaTip($tip) {
		self::$partitaIvaTip = $tip;
	}
	public function setPartitaIvaDisable($disable) {
		self::$partitaIvaDisable = $disable;
	}
	//-----------------------
	
	public function setTelefonoFisso($telefonoFisso) {
		self::$telefonoFisso = $telefonoFisso;	
	}	
	public function setTelefonoFissoStyle($style) {
		self::$telefonoFissoStyle = $style;
	}
	public function setTelefonoFissoTip($tip) {
		self::$telefonoFissoTip = $tip;
	}
	public function setTelefonoFissoDisable($disable) {
		self::$telefonoFissoDisable = $disable;
	}
	//-----------------------
	
	public function setTelefonoPortatile($telefonoPortatile) {
		self::$telefonoPortatile = $telefonoPortatile;	
	}	
	public function setTelefonoPortatileStyle($style) {
		self::$telefonoPortatileStyle = $style;
	}
	public function setTelefonoPortatileTip($tip) {
		self::$telefonoPortatileTip = $tip;
	}
	public function setTelefonoPortatileDisable($disable) {
		self::$telefonoPortatileDisable = $disable;
	}
	//-----------------------
	
	public function setEmail($email) {
		self::$email = $email;	
	}	
	public function setEmailStyle($style) {
		self::$emailStyle = $style;
	}
	public function setEmailTip($tip) {
		self::$emailTip = $tip;
	}
	public function setEmailDisable($disable) {
		self::$emailDisable = $disable;
	}
	//-----------------------
	
	public function setDataInserimento($dataInserimento) {
		self::$dataInserimento = $dataInserimento;	
	}	
	public function setDataInserimentoStyle($style) {
		self::$dataInserimentoStyle = $style;
	}
	public function setDataInserimentoTip($tip) {
		self::$dataInserimentoTip = $tip;
	}
	public function setDataInserimentoDisable($disable) {
		self::$dataInserimentoDisable = $disable;
	}
	//-----------------------
	
	public function setDataModifica($dataModifica) {
		self::$dataModifica = $dataModifica;	
	}	
	public function setDataModificaStyle($style) {
		self::$dataModificaStyle = $style;
	}
	public function setDataModificaTip($tip) {
		self::$dataModificaTip = $tip;
	}
	public function setDataModificaDisable($disable) {
		self::$dataModificaDisable = $disable;
	}
	//-----------------------
	
	public function setListino($listino) {
		self::$listino = $listino;	
	}
	public function setListinoStyle($style) {
		self::$listinoStyle = $style;	
	}
	public function setListinoTip($tip) {
		self::$listinoTip = $tip;	
	}
	public function setListinoDisable($disable) {
		self::$listinoDisable = $disable;	
	}
	//-----------------------	
			
	public function setMedico($medico) {
		self::$medico = $medico;	
	}
	public function setMedicoStyle($style) {
		self::$medicoStyle = $style;	
	}
	public function setMedicoTip($tip) {
		self::$medicoTip = $tip;	
	}
	public function setMedicoDisable($disable) {
		self::$medicoDisable = $disable;	
	}
	//-----------------------	
		
	public function setLaboratorio($laboratorio) {
		self::$laboratorio = $laboratorio;	
	}			
	public function setLaboratorioStyle($style) {
		self::$laboratorioStyle = $style;	
	}			
	public function setLaboratorioTip($tip) {
		self::$laboratorioTip = $tip;	
	}			
	public function setLaboratorioDisable($disable) {
		self::$laboratorioDisable = $disable;	
	}			
	//-----------------------	
		
	public function setTotaleVisiteIncorso($totaleVisiteIncorso) {
		self::$totaleVisiteIncorso = $totaleVisiteIncorso;	
	}			
	public function setTotaleVisitePreventivate($totaleVisitePreventivate) {
		self::$totaleVisitePreventivate = $totaleVisitePreventivate;	
	}			
	public function setTotalePreventiviProposti($totalePreventiviProposti) {
		self::$totalePreventiviProposti = $totalePreventiviProposti;	
	}			
	public function setTotalePreventiviAccettati($totalePreventiviAccettati) {
		self::$totalePreventiviAccettati = $totalePreventiviAccettati;	
	}			
	public function setTotaleCartelleAttive($totaleCartelleAttive) {
		self::$totaleCartelleAttive = $totaleCartelleAttive;	
	}			
	public function setTotaleCartelleIncorso($totaleCartelleIncorso) {
		self::$totaleCartelleIncorso = $totaleCartelleIncorso;	
	}			
	public function setTotaleCartelleChiuse($totaleCartelleChiuse) {
		self::$totaleCartelleChiuse = $totaleCartelleChiuse;	
	}			
	
	// Getters --------------------------------------------------------------------

	public function getPaziente() {
		return self::$paziente;
	}

	//--------------------------------------------------
		
	public function getCognome() {
		return self::$cognome;
	}
	public function getCognomeStyle() {
		return self::$cognomeStyle;
	}
	public function getCognomeTip() {
		return self::$cognomeTip;
	}
	public function getCognomeDisable() {
		return self::$cognomeDisable;
	}
	//--------------------------------------------------
		
	public function getNome() {
		return self::$nome;
	}
	public function getNomeStyle() {
		return self::$nomeStyle;
	}
	public function getNomeTip() {
		return self::$nomeTip;
	}
	public function getNomeDisable() {
		return self::$nomeDisable;
	}
	//-----------------------
		
	public function getIndirizzo() {
		return self::$indirizzo;
	}
	public function getIndirizzoStyle() {
		return self::$indirizzoStyle;
	}
	public function getIndirizzoTip() {
		return self::$indirizzoTip;
	}
	public function getIndirizzoDisable() {
		return self::$indirizzoDisable;
	}
	//-----------------------
		
	public function getCitta() {
		return self::$citta;
	}
	public function getCittaStyle() {
		return self::$cittaStyle;
	}
	public function getCittaTip() {
		return self::$cittaTip;
	}
	public function getCittaDisable() {
		return self::$cittaDisable;
	}
	//-----------------------
		
	public function getProvincia() {
		return self::$provincia;
	}
	public function getProvinciaStyle() {
		return self::$provinciaStyle;
	}
	public function getProvinciaTip() {
		return self::$provinciaTip;
	}
	public function getProvinciaDisable() {
		return self::$provinciaDisable;
	}
	//-----------------------
		
	public function getCap() {
		return self::$cap;
	}
	public function getCapStyle() {
		return self::$capStyle;
	}
	public function getCapTip() {
		return self::$capTip;
	}
	public function getCapDisable() {
		return self::$capDisable;
	}

	//-----------------------
		
	public function getLuogoNascita() {
		return self::$luogoNascita;
	}
	public function getLuogoNascitaStyle() {
		return self::$luogoNascitaStyle;
	}
	public function getLuogoNascitaTip() {
		return self::$luogoNascitaTip;
	}
	public function getLuogoNascitaDisable() {
		return self::$luogoNascitaDisable;
	}

	//-----------------------
		
	public function getDataNascita() {
		return self::$dataNascita;
	}
	public function getDataNascitaStyle() {
		return self::$dataNascitaStyle;
	}
	public function getDataNascitaTip() {
		return self::$dataNascitaTip;
	}
	public function getDataNascitaDisable() {
		return self::$dataNascitaDisable;
	}
	
	//-----------------------
		
	public function getSesso() {
		return self::$sesso;
	}
	public function getSessoStyle() {
		return self::$sessoStyle;
	}
	public function getSessoTip() {
		return self::$sessoTip;
	}
	public function getSessoDisable() {
		return self::$sessoDisable;
	}
	
	//-----------------------
		
	public function getTipo() {
		return self::$tipo;
	}
	public function getTipoStyle() {
		return self::$tipoStyle;
	}
	public function getTipoTip() {
		return self::$tipoTip;
	}
	public function getTipoDisable() {
		return self::$tipoDisable;
	}
	
	//-----------------------
		
	public function getCodiceFiscale() {
		return self::$codiceFiscale;
	}
	public function getCodiceFiscaleStyle() {
		return self::$codiceFiscaleStyle;
	}
	public function getCodiceFiscaleTip() {
		return self::$codiceFiscaleTip;
	}
	public function getCodiceFiscaleDisable() {
		return self::$codiceFiscaleDisable;
	}
	//-----------------------
		
	public function getPartitaIva() {
		return self::$partitaIva;
	}
	public function getPartitaIvaStyle() {
		return self::$partitaIvaStyle;
	}
	public function getPartitaIvaTip() {
		return self::$partitaIvaTip;
	}
	public function getPartitaIvaDisable() {
		return self::$partitaIvaDisable;
	}
	//-----------------------
		
	public function getTelefonoFisso() {
		return self::$telefonoFisso;
	}
	public function getTelefonoFissoStyle() {
		return self::$telefonoFissoStyle;
	}
	public function getTelefonoFissoTip() {
		return self::$telefonoFissoTip;
	}
	public function getTelefonoFissoDisable() {
		return self::$telefonoFissoDisable;
	}
	//-----------------------
		
	public function getTelefonoPortatile() {
		return self::$telefonoPortatile;
	}
	public function getTelefonoPortatileStyle() {
		return self::$telefonoPortatileStyle;
	}
	public function getTelefonoPortatileTip() {
		return self::$telefonoPortatileTip;
	}
	public function getTelefonoPortatileDisable() {
		return self::$telefonoPortatileDisable;
	}
	//-----------------------
		
	public function getEmail() {
		return self::$email;
	}
	public function getEmailStyle() {
		return self::$emailStyle;
	}
	public function getEmailTip() {
		return self::$emailTip;
	}
	public function getEmailDisable() {
		return self::$emailDisable;
	}
	//-----------------------
		
	public function getDataInserimento() {
		return self::$dataInserimento;
	}
	public function getDataInserimentoStyle() {
		return self::$dataInserimentoStyle;
	}
	public function getDataInserimentoTip() {
		return self::$dataInserimentoTip;
	}
	public function getDataInserimentoDisable() {
		return self::$dataInserimentoDisable;
	}
	//-----------------------
		
	public function getDataModifica() {
		return self::$dataModifica;
	}
	public function getDataModificaStyle() {
		return self::$dataModificaStyle;
	}
	public function getDataModificaTip() {
		return self::$dataModificaTip;
	}
	public function getDataModificaDisable() {
		return self::$dataModificaDisable;
	}
	//-----------------------
		
	public function getListino() {
		return self::$listino;
	}
	public function getListinoStyle() {
		return self::$listinoStyle;
	}
	public function getListinoTip() {
		return self::$listinoTip;
	}
	public function getListinoDisable() {
		return self::$listinoDisable;
	}
	//-----------------------
	
	public function getMedico() {
		return self::$medico;
	}
	public function getMedicoStyle() {
		return self::$medicoStyle;
	}
	public function getMedicoTip() {
		return self::$medicoTip;
	}
	public function getMedicoDisable() {
		return self::$medicoDisable;
	}
	//-----------------------	
	
	public function getLaboratorio() {
		return self::$laboratorio;
	}
	public function getLaboratorioStyle() {
		return self::$laboratorioStyle;
	}
	public function getLaboratorioTip() {
		return self::$laboratorioTip;
	}
	public function getLaboratorioDisable() {
		return self::$laboratorioDisable;
	}
	//-----------------------	
	
	public function getTotaleVisiteIncorso() {
		return self::$totaleVisiteIncorso;
	}
	public function getTotaleVisitePreventivate() {
		return self::$totaleVisitePreventivate;
	}
	public function getTotalePreventiviProposti() {
		return self::$totalePreventiviProposti;
	}
	public function getTotalePreventiviAccettati() {
		return self::$totalePreventiviAccettati;
	}
	public function getTotaleCartelleAttive() {
		return self::$totaleCartelleAttive;
	}
	public function getTotaleCartelleIncorso() {
		return self::$totaleCartelleIncorso;
	}
	public function getTotaleCartelleChiuse() {
		return self::$totaleCartelleChiuse;
	}

	// template ------------------------------------------------

	public function inizializzaPagina() {
	
		$this->setCognome("");
		$this->setCognomeDisable("");
		
		$this->setNome("");
		$this->setNomeDisable("");
		
		$this->setIndirizzo("");
		$this->setIndirizzoDisable("");
		
		$this->setCitta("");
		$this->setCittaDisable("");
		
		$this->setProvincia("");
		$this->setProvinciaDisable("");
		
		$this->setCap("");
		$this->setCapDisable("");
		
		$this->setEta("");
		$this->setEtaDisable("");
		
		$this->setLuogoNascita("");
		$this->setLuogoNascitaDisable("");
		
		$this->setDataNascita("");
		$this->setDataNascitaDisable("");
		
		$this->setSesso("M");
		$this->setSessoDisable("");
		
		$this->setTipo("D");
		$this->setTipoDisable("");
		
		$this->setCodiceFiscale("");
		$this->setCodiceFiscaleDisable("");
		
		$this->setPartitaIva("");
		$this->setPartitaIvaDisable("");
		
		$this->setTelefonoFisso("");
		$this->setTelefonoFissoDisable("");
		
		$this->setTelefonoPortatile("");
		$this->setTelefonoPortatileDisable("");
		
		$this->setEmail("");
		$this->setEmailDisable("");
		
		$this->setListino("");
		$this->setListinoDisable("");
		
		$this->setMedico("");
		$this->setMedicoDisable("");
		
		$this->setLaboratorio("");
		$this->setLaboratorioDisable("");
		
		$this->setDataInserimento(date("d/m/Y"));
		$this->setDataModifica("");

	}

	public function controlliLogici() {
		
		$esito = TRUE;

		include_once 'cf.class.php';
		
		$paziente = $this->getPaziente();
		
		if (!is_numeric($paziente->getCap())) {
			$esito = FALSE;
			$paziente->setCapStyle("border-color:#ff0000; border-width:2px;");
			$paziente->setCapTip("Il CAP del paziente deve contenere numeri");
		}

		$cf = new CodiceFiscale();
		$cf->SetCF($paziente->getCodiceFiscale());
		if (!($cf->GetCodiceValido())) { 
			$esito = FALSE;
			$paziente->setCodiceFiscaleStyle("border-color:#ff0000; border-width:2px;");
			$paziente->setCodiceFiscaleTip("Il codice fiscale immesso non è valido");
		}
		
		if ($paziente->getPartitaIva() != "") {
			if (!is_numeric($paziente->getPartitaIva())) {
				$esito = FALSE;
				$paziente->setPartitaIvaStyle("border-color:#ff0000; border-width:2px;");
				$paziente->setPartitaIvaTip("La partita iva del paziente deve contenere numeri");
			}
		}
		
		if (!is_numeric($paziente->getTelefonoFisso())) {
			$esito = FALSE;
			$paziente->setTelefonoFissoStyle("border-color:#ff0000; border-width:2px;");
			$paziente->setTelefonoFissoTip("Il telefono fisso del paziente deve contenere numeri");
		}

		if ($paziente->getTelefonoPortatile() != "") {
			if (!is_numeric($paziente->getTelefonoPortatile())) {
				$esito = FALSE;
				$paziente->setTelefonoPortatileStyle("border-color:#ff0000; border-width:2px;");
				$paziente->setTelefonoPortatileTip("Il telefono portatile del paziente deve contenere numeri");
			}
		}
			
		if ($paziente->getListino() == "") {
			$esito = FALSE;
			$paziente->setListinoStyle("color:#ff0000; border:2px solid;");
			$paziente->setListinoTip("Il listino deve essere selezionato");
		}	
			
		if ($paziente->getMedico() == "") {
			$esito = FALSE;
			$paziente->setMedicoStyle("color:#ff0000; border:2px solid;");
			$paziente->setMedicoTip("Il medico deve essere selezionato");
		}	
			
		if ($paziente->getLaboratorio() == "") {
			$esito = FALSE;
			$paziente->setLaboratorioStyle("color:#ff0000; border:2px solid;");
			$paziente->setLaboratorioTip("Il laboratorio deve essere selezionato");
		}	
		
		return $esito;
	}
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$paziente = $this->getPaziente();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		$db = new database();
		$listino = "<option value=''>";
		$medico = "<option value=''>";
		$laboratorio = "<option value=''>";

		//-------------------------------------------------------------
		$sql = "select idListino, descrizioneListino from paziente.listino";
		$result = $db->getData($sql);
		while ($row = pg_fetch_row($result)) {
			if ($paziente->getListino() == $row[0])
				$listino = $listino . "<option value='$row[0]' selected>$row[1]";
			else
				$listino = $listino . "<option value='$row[0]'>$row[1]";
		}
		//-------------------------------------------------------------
		$sql = "select idMedico, cognome, nome from paziente.medico";
		$result = $db->getData($sql);
		while ($row = pg_fetch_row($result)) {
			if ($paziente->getMedico() == $row[0])
				$medico = $medico . "<option value='$row[0]' selected>$row[1] $row[2]";
			else	
				$medico = $medico . "<option value='$row[0]' >$row[1] $row[2]";
		}
		//-------------------------------------------------------------
		$sql = "select idLaboratorio, nominativo from paziente.laboratorio";
		$result = $db->getData($sql);
		while ($row = pg_fetch_row($result)) {
			if ($paziente->getLaboratorio() == $row[0])
				$laboratorio = $laboratorio . "<option value='$row[0]' selected>$row[1]";
			else	
				$laboratorio = $laboratorio . "<option value='$row[0]' >$row[1]";
		}
		
		//-------------------------------------------------------------										

		if ($this->getTipo() == "D") {
			$tipoDefinitivo = "checked";
			$tipoProvvisorio = "";
		}
		if ($this->getTipo() == "P") {
			$tipoDefinitivo = "";
			$tipoProvvisorio = "checked";
		}


		if ($this->getSesso() == "M") {
			$sessoMaschio = "checked";
			$sessoFemmina = "";
		} else {
			$sessoMaschio = "";
			$sessoFemmina = "checked";
		}

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azione%' => $this->getAzione(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognome%' => $this->getCognome(),
			'%cognomeStyle%' => $this->getCognomeStyle(),
			'%cognomeTip%' => $this->getCognomeTip(),
			'%cognomeDisable%' => $this->getCognomeDisable(),
			'%nome%' => $this->getNome(),
			'%nomeStyle%' => $this->getNomeStyle(),
			'%nomeTip%' => $this->getNomeTip(),
			'%nomeDisable%' => $this->getNomeDisable(),
			'%indirizzo%' => $this->getIndirizzo(),
			'%indirizzoStyle%' => $this->getIndirizzoStyle(),
			'%indirizzoTip%' => $this->getIndirizzoTip(),
			'%indirizzoDisable%' => $this->getIndirizzoDisable(),
			'%citta%' => $this->getCitta(),
			'%cittaStyle%' => $this->getCittaStyle(),
			'%cittaTip%' => $this->getCittaTip(),
			'%cittaDisable%' => $this->getCittaDisable(),
			'%provincia%' => $this->getProvincia(),
			'%provinciaStyle%' => $this->getProvinciaStyle(),
			'%provinciaTip%' => $this->getProvinciaTip(),
			'%provinciaDisable%' => $this->getProvinciaDisable(),
			'%cap%' => $this->getCap(),
			'%capStyle%' => $this->getCapStyle(),
			'%capTip%' => $this->getCapTip(),
			'%capDisable%' => $this->getCapDisable(),
			'%luogoNascita%' => $this->getLuogoNascita(),
			'%luogoNascitaStyle%' => $this->getLuogoNascitaStyle(),
			'%luogoNascitaTip%' => $this->getLuogoNascitaTip(),
			'%luogoNascitaDisable%' => $this->getLuogoNascitaDisable(),
			'%dataNascita%' => $this->getDatanascita(),
			'%dataNascitaStyle%' => $this->getDatanascitaStyle() ,
			'%dataNascitaTip%' => $this->getDatanascitaTip(),
			'%dataNascitaDisable%' => $this->getDatanascitaDisable(),
			'%tipoDefinitivoChecked%' => $tipoDefinitivo,
			'%tipoProvvisorioChecked%' => $tipoProvvisorio,
			'%sessoMaschioChecked%' => $sessoMaschio,
			'%sessoFemminaChecked%' => $sessoFemmina,
			'%sesso%' => $this->getSesso(),
			'%sessoStyle%' => $this->getSessoStyle(),
			'%sessoTip%' => $this->getSessoTip(),
			'%sessoDisable%' => $this->getSessoDisable(),
			'%tipo%' => $this->getTipo(),
			'%tipoStyle%' => $this->getTipoStyle(),
			'%tipoTip%' => $this->getTipoTip(),
			'%tipoDisable%' => $this->getTipoDisable(),
			'%codiceFiscale%' => $this->getCodiceFiscale(),
			'%codiceFiscaleStyle%' => $this->getCodiceFiscaleStyle(),
			'%codiceFiscaleTip%' => $this->getCodiceFiscaleTip(),
			'%codiceFiscaleDisable%' => $this->getCodiceFiscaleDisable(),
			'%partitaIva%' => $this->getPartitaIva(),
			'%partitaIvaStyle%' => $this->getPartitaIvaStyle(),
			'%partitaIvaTip%' => $this->getPartitaIvaTip(),
			'%partitaIvaDisable%' => $this->getPartitaIvaDisable(),
			'%telefonoFisso%' => $this->getTelefonoFisso(),
			'%telefonoFissoStyle%' => $this->getTelefonoFissoStyle(),
			'%telefonoFissoTip%' => $this->getTelefonoFissoTip(),
			'%telefonoFissoDisable%' => $this->getTelefonoFissoDisable(),
			'%telefonoPortatile%' => $this->getTelefonoPortatile(),
			'%telefonoPortatileStyle%' => $this->getTelefonoPortatileStyle(),
			'%telefonoPortatileTip%' => $this->getTelefonoPortatileTip(),
			'%telefonoPortatileDisable%' => $this->getTelefonoPortatileDisable(),
			'%email%' => $this->getEmail(),
			'%emailStyle%' => $this->getEmailStyle(),
			'%emailTip%' => $this->getEmailTip(),
			'%emailDisable%' => $this->getEmailDisable(),
			'%dataInserimento%' => $this->getDataInserimento(),
			'%dataInserimentoStyle%' => $this->getDataInserimentoStyle(),
			'%dataInserimentoTip%' => $this->getDataInserimentoTip(),
			'%dataInserimentoDisable%' => $this->getDataInserimentoDisable(),
			'%dataModifica%' => $this->getDataModifica(),
			'%dataModificaStyle%' => $this->getDataModificaStyle(),
			'%dataModificaTip%' => $this->getDataModificaTip(),
			'%dataModificaDisable%' => $this->getDataModificaDisable(),
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%listino%' => $listino,
			'%listinoStyle%' => $this->getListinoStyle(),
			'%listinoTip%' => $this->getListinoTip(),
			'%listinoDisable%' => $this->getListinoDisable(),
			'%medico%' => $medico,
			'%medicoStyle%' => $this->getMedicoStyle(),
			'%medicoTip%' => $this->getMedicoTip(),
			'%medicoDisable%' => $this->getMedicoDisable(),
			'%laboratorio%' => $laboratorio,
			'%laboratorioStyle%' => $this->getLaboratorioStyle(),
			'%laboratorioTip%' => $this->getLaboratorioTip(),
			'%laboratorioDisable%' => $this->getLaboratorioDisable()
		);

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}	
	
	public function displayTotali() {

		$paziente = $this->getPaziente();

		if (($this->getTotaleVisiteIncorso() > 0) or ($this->getTotaleVisitePreventivate() > 0))		
			$this->displayTotaliVisite();

		if (($this->getTotalePreventiviProposti() > 0) or ($this->getTotalePreventiviAccettati() > 0))		
			$this->displayTotaliPreventivi();

		if (($this->getTotaleCartelleAttive() > 0) or ($this->getTotaleCartelleIncorso() > 0) or ($this->getTotaleCartelleChiuse() > 0))		
			$this->displayTotaliCartelleCliniche();
	}
	
	private function displayTotaliVisite() {

		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$totaliVisita;
		
		$replace = array(
			'%numvisite_incorso%' => $this->getTotaleVisiteIncorso(),
			'%numvisite_preventivate%' => $this->getTotaleVisitePreventivate()
		);		

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}

	private function displayTotaliPreventivi() {

		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$totaliPreventivo;
		
		$replace = array(
			'%numpreventivi_proposti%' => $this->getTotalePreventiviProposti(),
			'%numpreventivi_accettati%' => $this->getTotalePreventiviAccettati()
		);		

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}

	private function displayTotaliCartelleCliniche() {

		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$totaliCartelle;
		
		$replace = array(
			'%numcartellecliniche_attive%' => $this->getTotaleCartelleAttive(),
			'%numcartellecliniche_incorso%' => $this->getTotaleCartelleIncorso(),
			'%numcartellecliniche_chiuse%' => $this->getTotaleCartelleChiuse()
		);		

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}	
}	

?>
