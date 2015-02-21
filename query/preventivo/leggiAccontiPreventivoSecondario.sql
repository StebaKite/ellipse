select
	idaccontosottopreventivo as idacconto,
	to_char(datascadenza, 'DD/MM/YYYY') as datascadenza,
	datascadenza as data,
	descrizione,
	importo,
	stato
 from paziente.accontosottopreventivo
 where idsottopreventivo = %idsottopreventivo%
 order by data