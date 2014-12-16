SELECT
	paziente.idpaziente,
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
	idlaboratorio,
	coalesce(visita.numvisite,0) as numvisite,
	coalesce(preventivo.numpreventivi,0) as numpreventivi,
	coalesce(cartellaclinica.numcartellecliniche,0) as numcartellecliniche
	
FROM paziente.paziente as paziente

	left outer join (
		select idpaziente, count(*) as numvisite
		from paziente.visita
		group by idpaziente
	) as visita
	on visita.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numpreventivi
		from paziente.preventivo
		group by idpaziente
	) as preventivo
	on preventivo.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numcartellecliniche
		from paziente.cartellaclinica
		group by idpaziente
	) as cartellaclinica
	on cartellaclinica.idpaziente = paziente.idpaziente

WHERE paziente.idpaziente = %idpaziente%
