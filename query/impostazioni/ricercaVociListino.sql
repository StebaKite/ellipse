SELECT
	vocelistino.idvocelistino,
	vocelistino.prezzo,
	vocelistino.datainserimento,
	vocelistino.datamodifica,
	voce.codice as codicevoce,
	voce.descrizione as descrizionevoce,
	COALESCE(lispaz.numpazienti, 0) as numPazienti
	
FROM paziente.vocelistino as vocelistino

	INNER JOIN paziente.voce as voce
		ON voce.idvoce = vocelistino.idvocelistino

	LEFT OUTER JOIN
		(SELECT idlistino, count(*) as numpazienti
		   FROM paziente.paziente
		  GROUP BY idlistino
		) as lispaz
		ON lispaz.idlistino = vocelistino.idlistino
		
WHERE vocelistino.idlistino = %idlistino%
ORDER BY vocelistino.datainserimento desc