SELECT 
  'P' as tipopreventivo,
  preventivo.idpreventivo,
  null as idsottopreventivo,
  to_char(preventivo.datainserimento, 'DD/MM/YYYY') as datainserimento,
  to_char(preventivo.datamodifica, 'DD/MM/YYYY') as datamodifica,
  preventivo.stato
  
FROM paziente.preventivo as preventivo
WHERE preventivo.idpaziente = %idpaziente%

UNION ALL

SELECT 
  'S' as tipopreventivo,
  sottopreventivo.idpreventivo,
  sottopreventivo.idsottopreventivo,
  to_char(sottopreventivo.datainserimento, 'DD/MM/YYYY') as datainserimento,
  to_char(sottopreventivo.datamodifica, 'DD/MM/YYYY') as datamodifica,
  sottopreventivo.stato

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.sottopreventivo as sottopreventivo 
		ON sottopreventivo.idpreventivo = preventivo.idpreventivo

WHERE preventivo.idpaziente = %idpaziente%

ORDER BY idpreventivo, tipopreventivo, idsottopreventivo, datainserimento
