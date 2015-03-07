select
	notasottopreventivo.idnotasottopreventivo as idnotapreventivo,
	notasottopreventivo.nota,
	notasottopreventivo.datainserimento,
	notasottopreventivo.datamodifica
  from paziente.notasottopreventivo as notasottopreventivo
  where idsottopreventivo = %idpreventivo%
  order by notasottopreventivo.datainserimento, notasottopreventivo.idnotasottopreventivo
  
	