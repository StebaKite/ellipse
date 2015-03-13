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
	coalesce(visiteproposte.numvisiteproposte, 0) as numvisiteproposte,
	coalesce(preventivo.numpreventivi, 0) as numpreventivi,
	coalesce(preventiviproposti.numpreventiviproposti, 0) as numpreventiviproposti,
	coalesce(sottopreventivo.numsottopreventivi, 0) as numsottopreventivi,
	coalesce(sottopreventiviproposti.numsottopreventiviproposti, 0) as numsottopreventiviproposti,
	coalesce(cartellaclinica.numcartellecliniche, 0) as numcartellecliniche
	
 from paziente.paziente as paziente
 
	left outer join (
		select idpaziente, count(*) as numvisite
		from paziente.visita
		group by idpaziente
	) as visita
	on visita.idpaziente = paziente.idpaziente
 
	left outer join (
		select idpaziente, count(*) as numvisiteproposte
		from paziente.visita
		where stato = '00'
		group by idpaziente
	) as visiteproposte
	on visiteproposte.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numpreventivi
		from paziente.preventivo
		group by idpaziente
	) as preventivo
	on preventivo.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numpreventiviproposti
		from paziente.preventivo
		where stato = '00'
		group by idpaziente
	) as preventiviproposti
	on preventiviproposti.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numsottopreventivi
		from paziente.preventivo
			inner join paziente.sottopreventivo as sottopreventivo
				on sottopreventivo.idpreventivo = preventivo.idpreventivo
		group by idpaziente
	) as sottopreventivo
	on sottopreventivo.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numsottopreventiviproposti
		from paziente.preventivo
			inner join paziente.sottopreventivo as sottopreventivo
				on sottopreventivo.idpreventivo = preventivo.idpreventivo
		where sottopreventivo.stato = '00'		
		group by idpaziente
	) as sottopreventiviproposti
	on sottopreventiviproposti.idpaziente = paziente.idpaziente
	
	left outer join (
		select idpaziente, count(*) as numcartellecliniche
		from paziente.cartellaclinica
		group by idpaziente
	) as cartellaclinica
	on cartellaclinica.idpaziente = paziente.idpaziente
	
where cognome like '%cognome%%'
%datamodifica%
%proposte%
order by paziente.cognome, paziente.nome
