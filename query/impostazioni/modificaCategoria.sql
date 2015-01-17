UPDATE paziente.categoria
SET
	codicecategoria = '%codicecategoria%',
	descrizionecategoria = '%descrizionecategoria%',
	datamodifica = current_date
		
WHERE idcategoria = %idcategoria%