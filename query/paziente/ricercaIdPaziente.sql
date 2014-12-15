SELECT
	idpaziente,
	cognome,
	nome,
	indirizzo,
	citta,
	cap,
	provincia,
	eta,
	sesso,
	tipo,
	luogonascita,
	datanascita,
	codicefiscale,
	partitaiva,
	telefonofisso,
	telefonoportatile,
	email,
	to_char(datainserimento, 'DD/MM/YYYY') as datainserimento,
	to_char(datamodifica, 'DD/MM/YYYY') as datamodifica,
	idlistino,
	idmedico,
	idlaboratorio
	
FROM paziente.paziente
WHERE idpaziente = %idpaziente%
