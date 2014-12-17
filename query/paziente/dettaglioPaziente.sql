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
	coalesce(visitaIncorso.numvisite_incorso, 0) as numvisite_incorso,
	coalesce(visitaPrev.numvisite_preventivate, 0) as numvisite_preventivate,
	coalesce(preventivoProp.numpreventivi_proposti, 0) as numpreventivi_proposti,
	coalesce(preventivoAcc.numpreventivi_accettati, 0) as numpreventivi_accettati,
	coalesce(cartellaclinicaAtt.numcartellecliniche_attive, 0) as numcartellecliniche_attive,
	coalesce(cartellaclinicaIncorso.numcartellecliniche_incorso, 0) as numcartellecliniche_incorso,
	coalesce(cartellaclinicaChiu.numcartellecliniche_chiuse, 0) as numcartellecliniche_chiuse
	
FROM paziente.paziente as paziente
 
	left outer join (
		select idpaziente, count(*) as numvisite_incorso
		from paziente.visita
		where stato = '00'
		group by idpaziente
	) as visitaIncorso
	on visitaIncorso.idpaziente = paziente.idpaziente
 
	left outer join (
		select idpaziente, count(*) as numvisite_preventivate
		from paziente.visita
		where stato = '01'
		group by idpaziente
	) as visitaPrev
	on visitaPrev.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numpreventivi_proposti
		from paziente.preventivo
		where stato = '00'
		group by idpaziente
	) as preventivoProp
	on preventivoProp.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numpreventivi_accettati
		from paziente.preventivo
		where stato = '01'
		group by idpaziente
	) as preventivoAcc
	on preventivoAcc.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numcartellecliniche_attive
		from paziente.cartellaclinica
		where stato = '00'
		group by idpaziente
	) as cartellaclinicaAtt
	on cartellaclinicaAtt.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numcartellecliniche_incorso
		from paziente.cartellaclinica
		where stato = '01'
		group by idpaziente
	) as cartellaclinicaIncorso
	on cartellaclinicaIncorso.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numcartellecliniche_chiuse
		from paziente.cartellaclinica
		where stato = '02'
		group by idpaziente
	) as cartellaclinicaChiu
	on cartellaclinicaChiu.idpaziente = paziente.idpaziente

WHERE paziente.idpaziente = %idpaziente%
