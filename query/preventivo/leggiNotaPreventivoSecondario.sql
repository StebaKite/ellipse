select
	nota,
	datainserimento,
	datamodifica
 from paziente.notasottopreventivo
 where idsottopreventivo = %idsottopreventivo%
   and idnotasottopreventivo = %idnotasottopreventivo%