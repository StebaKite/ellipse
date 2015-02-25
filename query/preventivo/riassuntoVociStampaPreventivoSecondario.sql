SELECT

	vocesottopreventivo.codicevocelistino as codicevoce,
	case
		when vocesottopreventivo.descrizione is null then voce.descrizione
		when vocesottopreventivo.descrizione is not null then vocesottopreventivo.descrizione
	end as descrizionevoce,
	count(*) as quantitavoce,
	sum(vocesottopreventivo.prezzo) as totalevoce

FROM paziente.sottopreventivo as sottopreventivo

	INNER JOIN paziente.preventivo as preventivo
		ON preventivo.idpreventivo = sottopreventivo.idpreventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.vocesottopreventivo as vocesottopreventivo
		ON vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocesottopreventivo.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND sottopreventivo.idsottopreventivo = %idsottopreventivo%
  
GROUP BY codicevoce, descrizionevoce
