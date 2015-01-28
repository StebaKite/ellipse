SELECT 
  'P' as tipopreventivo,
  preventivo.idpreventivo,
  null as idsottopreventivo,
  to_char(preventivo.datainserimento, 'DD/MM/YYYY') as datainserimento,
  to_char(preventivo.datamodifica, 'DD/MM/YYYY') as datamodifica,
  preventivo.stato,
  coalesce(totalipreventivipaziente.totalepreventivo, 0) as totalepreventivo
  
FROM paziente.preventivo as preventivo

	LEFT OUTER JOIN
	
		(SELECT preventivo.idpreventivo, SUM(vocepreventivo.prezzo) AS totalepreventivo
		   FROM paziente.preventivo AS preventivo
		   
		   		INNER JOIN paziente.vocepreventivo AS vocepreventivo
			   		ON vocepreventivo.idpreventivo = preventivo.idpreventivo
			   		
		  WHERE preventivo.idpaziente = %idpaziente%
		  GROUP BY preventivo.idpreventivo
		) AS totalipreventivipaziente
		
		ON totalipreventivipaziente.idpreventivo = preventivo.idpreventivo

WHERE preventivo.idpaziente = %idpaziente%

UNION ALL

SELECT 
  'S' as tipopreventivo,
  sottopreventivo.idpreventivo,
  sottopreventivo.idsottopreventivo,
  to_char(sottopreventivo.datainserimento, 'DD/MM/YYYY') as datainserimento,
  to_char(sottopreventivo.datamodifica, 'DD/MM/YYYY') as datamodifica,
  sottopreventivo.stato,
  coalesce(totalisottopreventivipaziente.totalesottopreventivo, 0) as totalepreventivo

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.sottopreventivo as sottopreventivo 
		ON sottopreventivo.idpreventivo = preventivo.idpreventivo

	LEFT OUTER JOIN
	
		(SELECT sottopreventivo.idpreventivo, SUM(vocesottopreventivo.prezzo) AS totalesottopreventivo
		   FROM paziente.preventivo AS preventivo
		   
				INNER JOIN paziente.sottopreventivo as sottopreventivo 
					ON sottopreventivo.idpreventivo = preventivo.idpreventivo
					
		   		INNER JOIN paziente.vocesottopreventivo AS vocesottopreventivo
			   		ON vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo
			   		
		  WHERE preventivo.idpaziente = %idpaziente%
		  GROUP BY sottopreventivo.idpreventivo
		) AS totalisottopreventivipaziente
		
		ON totalisottopreventivipaziente.idpreventivo = preventivo.idpreventivo


WHERE preventivo.idpaziente = %idpaziente%

ORDER BY idpreventivo, tipopreventivo, idsottopreventivo, datainserimento
