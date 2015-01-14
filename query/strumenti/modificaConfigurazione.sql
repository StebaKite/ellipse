UPDATE strumenti.guida
SET
	progressivo = %progressivo%,
	classe = '%classe%',
	filepath = '%filepath%',
	stato = '%stato%'
		
WHERE idguida = %idguida%