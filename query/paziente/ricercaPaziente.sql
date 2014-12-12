select
	idpaziente,
	cognome,
	nome,
	to_char(datanascita, 'DD/MM/YYYY'),
	codicefiscale
 from paziente.paziente
 where cognome like '%cognome%%'
