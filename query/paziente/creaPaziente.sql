INSERT INTO paziente.paziente VALUES (
	nextval('paziente.paziente_idpaziente_seq'),
	'%cognome%',
	'%nome%',
	'%tipo%',
	'%indirizzo%',
	'%citta%',
	'%cap%',
	'%provincia%',
	'%sesso%',
	'%luogonascita%',
	'%datanascita%',
	'%codicefiscale%',
	'%partitaiva%',
	'%telefonofisso%',
	'%telefonoportatile%',
	'%email%',
	current_date,
	null,
	null,
	%idmedico%,
	%idlaboratorio%,
	%idlistino%
	)
