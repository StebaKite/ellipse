select
	nota,
	datainserimento,
	datamodifica
 from paziente.notapreventivo
 where idpreventivo = %idpreventivo%
   and idnotapreventivo = %idnotapreventivo%