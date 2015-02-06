SELECT
	idvisita,
	datainserimento
	
FROM paziente.visita

WHERE idpaziente = %idpaziente%
AND   stato = '%stato%'	
