SELECT

	vocevisita.codicevocelistino,
	substring(vocevisita.nomecampoform, position(';' in vocevisita.nomecampoform) + 1) as nomecampoform,
	vocevisita.nomeform,
	voce.descrizione as descrizionevoce

FROM paziente.visita as visita

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = visita.idpaziente
	
	LEFT OUTER JOIN paziente.vocevisita as vocevisita
		ON vocevisita.idvisita = visita.idvisita
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocevisita.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND visita.idvisita = %idvisita%
  AND vocevisita.nomeform = '%nomeform%'
  
ORDER BY vocevisita.codicevocelistino, vocevisita.nomecampoform
