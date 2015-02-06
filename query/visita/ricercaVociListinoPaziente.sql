SELECT
	voce.codice as codicevocelistino,
	voce.descrizione as descrizionevoce
	
FROM paziente.vocelistino as vocelistino

	INNER JOIN paziente.voce as voce
	ON  voce.idvoce = vocelistino.idvocelistino
	AND voce.tipo = 'STD'

WHERE vocelistino.idlistino = %idlistino%
ORDER BY voce.codice
