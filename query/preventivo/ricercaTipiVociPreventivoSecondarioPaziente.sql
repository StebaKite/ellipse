SELECT

	DISTINCT vocesottopreventivo.nomeform as tipoVoce

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.sottopreventivo as sottopreventivo
		ON sottopreventivo.idpreventivo = preventivo.idpreventivo
	
	LEFT OUTER JOIN paziente.vocesottopreventivo as vocesottopreventivo
		ON vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND sottopreventivo.idsottopreventivo = %idsottopreventivo%
  AND vocesottopreventivo.stato = '00'
