SELECT 

	categoria.idcategoria,
	categoria.codicecategoria,
  	categoria.descrizionecategoria,
	TO_CHAR(categoria.datainserimento, 'DD/MM/YYYY') as datainserimento,
	TO_CHAR(categoria.datamodifica, 'DD/MM/YYYY') as datamodifica,	
  	COALESCE(voce.numvoci, 0) as numvoci
  
FROM paziente.categoria as categoria

	LEFT OUTER JOIN (
		select idcategoria, count(*) as numvoci
		from paziente.voce
		group by idcategoria
	) as voce
	on voce.idcategoria = categoria.idcategoria

ORDER BY codicecategoria
