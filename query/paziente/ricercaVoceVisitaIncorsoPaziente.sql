SELECT
	idvocevisita,
	datainserimento
	
FROM paziente.vocevisita

WHERE idvisita = %idvisita%
AND   nomecampoform = '%nomecampoform%'
AND   codicevocelistino = '%codicevocelistino%'	
