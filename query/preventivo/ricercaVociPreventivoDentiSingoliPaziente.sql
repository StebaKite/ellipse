SELECT

	vocepreventivo.nomecampoform,
	vocepreventivo.codicevocelistino

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
  AND vocepreventivo.nomeform = 'singoli'
  AND vocepreventivo.stato = '00'
  