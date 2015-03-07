select
	notapreventivo.idnotapreventivo,
	notapreventivo.nota,
	notapreventivo.datainserimento,
	notapreventivo.datamodifica
  from paziente.notapreventivo as notapreventivo
  where idpreventivo = %idpreventivo%
  order by notapreventivo.datainserimento, notapreventivo.idnotapreventivo
  
	