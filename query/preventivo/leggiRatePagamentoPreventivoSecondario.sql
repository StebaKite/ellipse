select
	datascadenza,
	stato,
	importo
 from paziente.ratasottopreventivo
 where idsottopreventivo = %idsottopreventivo%
 order by datascadenza	