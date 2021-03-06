SELECT DISTINCT
	categoria.codicecategoria, 
	categoria.descrizionecategoria
	
FROM paziente.vocelistino as vocelistino

	INNER JOIN paziente.voce as voce
	ON  voce.idvoce = vocelistino.idvocelistino
	AND voce.tipo = 'STD'

	INNER JOIN paziente.categoria as categoria
	ON  categoria.idcategoria = voce.idcategoria

WHERE vocelistino.idlistino = %idlistino%

ORDER BY categoria.codicecategoria
