UPDATE paziente.paziente
 SET
	cognome='%cognome%',
	nome='%nome%',
	tipo='%tipo%',
	indirizzo='%indirizzo%',
	citta='%citta%',
	cap='%cap%',
	provincia='%provincia%',
	eta='%eta%',
	sesso='%sesso%',
	luogonascita='%luogoNascita%',
	datanascita='%dataNascita%',
	codicefiscale='%codiceFiscale%',
	partitaiva='%partitaIva%',
	telefonofisso='%telefonoFisso%',
	telefonoportatile='%telefonoPortatile%',
	email='%email%',
	datainserimento='%dataInserimento%',
	datamodifica=current_date,
	idmedico=%medico%,
	idlaboratorio=%laboratorio%,
	idlistino=%listino%

WHERE idpaziente=%idPaziente%
