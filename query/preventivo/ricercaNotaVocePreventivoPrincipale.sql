select
	notavocepreventivo.idnotavocepreventivo,
	notavocepreventivo.nota,
	notavocepreventivo.datainserimento,
	notavocepreventivo.datamodifica
  from paziente.notavocepreventivo as notavocepreventivo
  where idvocepreventivo = %idvocepreventivo%
  order by notavocepreventivo.datainserimento, notavocepreventivo.idnotavocepreventivo
  
	