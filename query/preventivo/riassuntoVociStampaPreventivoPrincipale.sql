SELECT

	vocepreventivo.codicevocelistino as codicevoce,
	case
		when vocepreventivo.descrizione is null then voce.descrizione
		when vocepreventivo.descrizione is not null then vocepreventivo.descrizione
	end as descrizionevoce,
	count(*) as quantitavoce,
	sum(vocepreventivo.prezzo) as totalevoce

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.vocepreventivo as vocepreventivo
		ON vocepreventivo.idpreventivo = preventivo.idpreventivo
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocepreventivo.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  
GROUP BY codicevoce, descrizionevoce
