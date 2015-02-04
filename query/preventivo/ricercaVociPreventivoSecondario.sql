SELECT

	substring(vocesottopreventivo.nomecampoform, 0, position(';' in vocesottopreventivo.nomecampoform)) as gruppo,
	substring(vocesottopreventivo.nomecampoform, position(';' in vocesottopreventivo.nomecampoform) + 1) as dente,
	vocesottopreventivo.codicevocelistino,
	vocesottopreventivo.prezzo,
	vocesottopreventivo.nomeform,
	vocesottopreventivo.nomecampoform,
	vocesottopreventivo.idvocesottopreventivo

  FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		on paziente.idpaziente = preventivo.idpaziente

	LEFT OUTER JOIN paziente.sottopreventivo as sottopreventivo
		on sottopreventivo.idpreventivo = preventivo.idpreventivo
	
	LEFT OUTER JOIN paziente.vocesottopreventivo as vocesottopreventivo
		on vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocesottopreventivo.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND sottopreventivo.idsottopreventivo = %idsottopreventivo%
  AND vocesottopreventivo.stato = '00'

ORDER BY vocesottopreventivo.nomecampoform