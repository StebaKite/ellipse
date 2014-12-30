SELECT

	vocevisita.nomecampoform,
	vocevisita.codicevocelistino

FROM paziente.visita as visita

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = visita.idpaziente
	
	LEFT OUTER JOIN paziente.vocevisita as vocevisita
		on vocevisita.idvisita = visita.idvisita
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocevisita.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND visita.idvisita = %idvisita%
  AND vocevisita.nomeform = 'gruppi'
