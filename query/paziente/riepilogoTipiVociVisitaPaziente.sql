SELECT

	DISTINCT vocevisita.nomeform as tipoVoce

FROM paziente.visita as visita

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = visita.idpaziente
	
	LEFT OUTER JOIN paziente.vocevisita as vocevisita
		ON vocevisita.idvisita = visita.idvisita
	
WHERE paziente.idpaziente = %idpaziente%
  AND visita.idvisita = %idvisita%
