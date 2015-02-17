select
	idaccontosottopreventivo as idacconto,
	datascadenza,
	descrizione,
	importo,
	stato
 from paziente.accontosottopreventivo
 where idsottopreventivo = %idsottopreventivo%
 order by datascadenza	