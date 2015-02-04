SELECT

	substring(vocepreventivo.nomecampoform, 0, position(';' in vocepreventivo.nomecampoform)) as gruppo,
	substring(vocepreventivo.nomecampoform, position(';' in vocepreventivo.nomecampoform) + 1) as dente,
	vocepreventivo.codicevocelistino,
	vocepreventivo.prezzo,
	vocepreventivo.nomeform,
	vocepreventivo.nomecampoform,
	vocepreventivo.idvocepreventivo

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		on paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.vocepreventivo as vocepreventivo
		on vocepreventivo.idpreventivo = preventivo.idpreventivo
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocepreventivo.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND vocepreventivo.stato = '00'
    
ORDER BY vocepreventivo.nomecampoform  