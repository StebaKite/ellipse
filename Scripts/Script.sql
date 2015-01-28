SELECT 
  'S' as tipopreventivo,
  sottopreventivo.idpreventivo,
  sottopreventivo.idsottopreventivo,
  to_char(sottopreventivo.datainserimento, 'DD/MM/YYYY') as datainserimento,
  to_char(sottopreventivo.datamodifica, 'DD/MM/YYYY') as datamodifica,
  sottopreventivo.stato,
  coalesce(totalipreventivipaziente.totalepreventivo, 0) as totalepreventivo

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.sottopreventivo as sottopreventivo 
		ON sottopreventivo.idpreventivo = preventivo.idpreventivo

	LEFT OUTER JOIN
	
		(
		SELECT sottopreventivo.idpreventivo, SUM(vocesottopreventivo.prezzo) AS totalesottopreventivo
		   FROM paziente.preventivo AS preventivo
				INNER JOIN paziente.sottopreventivo as sottopreventivo 
					ON sottopreventivo.idpreventivo = preventivo.idpreventivo
		   		INNER JOIN paziente.vocesottopreventivo AS vocesottopreventivo
			   		ON vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo
		  WHERE preventivo.idpaziente = 4
		  GROUP BY sottopreventivo.idpreventivo
		) AS totalisottopreventivipaziente
		
		ON totalisottopreventivipaziente.idpreventivo = preventivo.idpreventivo


WHERE preventivo.idpaziente = 4
