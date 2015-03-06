SELECT

	DISTINCT vocepreventivo.nomeform as tipoVoce

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.vocepreventivo as vocepreventivo
		ON vocepreventivo.idpreventivo = preventivo.idpreventivo
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND vocepreventivo.stato = '00'
