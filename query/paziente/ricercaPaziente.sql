select
	paziente.idpaziente,
	paziente.cognome,
	paziente.nome,
	paziente.tipo,
	paziente.idlistino,
	to_char(paziente.datainserimento, 'DD/MM/YYYY') as datainserimento,
	to_char(paziente.datamodifica, 'DD/MM/YYYY') as datamodifica,	
	to_char(paziente.datanascita, 'DD/MM/YYYY') as datanascita,
	coalesce(visita.numvisite, 0) as numvisite,
	coalesce(preventivo.numpreventivi, 0) as numpreventivi,
	coalesce(cartellaclinica.numcartellecliniche, 0) as numcartellecliniche
	
 from paziente.paziente as paziente
 
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
	
where cognome like '%cognome%%'
order by paziente.cognome, paziente.nome
