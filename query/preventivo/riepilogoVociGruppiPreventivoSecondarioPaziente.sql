SELECT

	vocesottopreventivo.idvocesottopreventivo,
	vocesottopreventivo.codicevocelistino,
	substring(vocesottopreventivo.nomecampoform, position(';' in vocesottopreventivo.nomecampoform) + 1) as nomecampoform,
	vocesottopreventivo.nomeform,
	vocesottopreventivo.prezzo,
	case
		when vocesottopreventivo.descrizione is null then voce.descrizione
		when vocesottopreventivo.descrizione is not null then vocesottopreventivo.descrizione
	end as descrizionevoce

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.sottopreventivo as sottopreventivo
		ON sottopreventivo.idpreventivo = preventivo.idpreventivo
	
	LEFT OUTER JOIN paziente.vocesottopreventivo as vocesottopreventivo
		ON vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocesottopreventivo.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND sottopreventivo.idsottopreventivo = %idsottopreventivo%
  AND vocesottopreventivo.nomeform = '%nomeform%'
  AND vocesottopreventivo.stato = '00'
  
ORDER BY vocesottopreventivo.codicevocelistino, vocesottopreventivo.nomecampoform
